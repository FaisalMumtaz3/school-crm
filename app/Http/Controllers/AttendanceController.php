<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Section;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Attendance records / dashboard.
     */
    public function index(Request $request)
    {
        $query = Attendance::with([
            'student.schoolClass',
            'student.studentSection',
        ])
            ->orderByDesc('date')
            ->orderBy('id');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('class')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class', $request->class);
            });
        }

        if ($request->filled('section')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('section', $request->section);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('roll_number', 'like', "%{$search}%");
            });
        }

        $attendances = $query->paginate(20)->withQueryString();

        $classes = SchoolClass::query()
            ->orderBy('name')
            ->get();

        $sections = Section::query()
            ->orderBy('name')
            ->get();

        return view('attendances.index', compact(
            'attendances',
            'classes',
            'sections'
        ));
    }


    /**
     * Show attendance taking page.
     */
    public function create(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));

        $selectedClass = $request->input('class');
        $selectedSection = $request->input('section');

        /*
        |--------------------------------------------------------------------------
        | Classes
        |--------------------------------------------------------------------------
        */

        $classes = Student::query()
            ->whereNotNull('class')
            ->where('class', '!=', '')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');


        /*
        |--------------------------------------------------------------------------
        | Sections
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | If your students.section contains the section ID,
        | we retrieve the section records here.
        |
        */

        $sections = Section::query()->orderBy('name')->get();


        /*
        |--------------------------------------------------------------------------
        | Students
        |--------------------------------------------------------------------------
        */

        $students = collect();

        if ($selectedClass) {

            $studentsQuery = Student::query()
                ->where('class', $selectedClass)
                ->orderBy('roll_number')
                ->orderBy('name');

            if ($selectedSection) {
                $studentsQuery->where('section', $selectedSection);
            }

            $students = $studentsQuery->get();


            /*
            |--------------------------------------------------------------------------
            | Existing Attendance
            |--------------------------------------------------------------------------
            */

            $existingAttendance = Attendance::query()
                ->whereDate('date', $date)
                ->whereIn('student_id', $students->pluck('id'))
                ->get()
                ->keyBy('student_id');


            /*
            |--------------------------------------------------------------------------
            | Attach Attendance Status
            |--------------------------------------------------------------------------
            */

            $students->each(function ($student) use ($existingAttendance) {

                $attendance = $existingAttendance->get($student->id);

                $student->attendance_status = $attendance
                    ? $attendance->status
                    : 'present';

                $student->attendance_remarks = $attendance
                    ? $attendance->remarks
                    : null;
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('attendances.create', [
            'date' => $date,
            'classes' => $classes,
            'sections' => $sections,
            'students' => $students,
            'selectedClass' => $selectedClass,
            'selectedSection' => $selectedSection,
        ]);
    }


    /**
     * Save attendance.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
            ],

            'class' => [
                'required',
                'string',
            ],

            'section' => [
                'nullable',
                'string',
            ],

            'attendance' => [
                'required',
                'array',
            ],

            'attendance.*.status' => [
                'required',
                'in:present,absent,leave',
            ],

            'attendance.*.remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            foreach ($validated['attendance'] as $studentId => $data) {

                /*
                 * Make sure the student actually belongs
                 * to the selected class/section.
                 */
                $student = Student::find($studentId);

                if (!$student) {
                    continue;
                }

                if ((string) $student->class !== (string) $validated['class']) {
                    continue;
                }

                if (
                    !empty($validated['section']) &&
                    (string) $student->section !== (string) $validated['section']
                ) {
                    continue;
                }

                Attendance::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'date' => $validated['date'],
                    ],
                    [
                        'status' => $data['status'],
                        'remarks' => $data['remarks'] ?? null,
                    ]
                );
            }
        });

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Attendance saved successfully.');
    }


    /**
     * Show attendance for a particular date/class.
     */
    public function show(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class' => 'required|string',
            'section' => 'nullable|string',
        ]);

        $studentsQuery = Student::query()
            ->where('class', $request->class)
            ->orderBy('roll_number')
            ->orderBy('name');

        if ($request->filled('section')) {
            $studentsQuery->where('section', $request->section);
        }

        $students = $studentsQuery->get();

        $attendance = Attendance::with('student')
            ->whereDate('date', $request->date)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        return view('attendances.show', compact(
            'students',
            'attendance'
        ));
    }
}