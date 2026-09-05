<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    /**
     * Fee records.
     */
    public function index(Request $request)
    {
        $query = Fee::with([
            'student',
        ])
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->orderBy('id');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('student', function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('roll_number', 'like', "%{$search}%");

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Month
        |--------------------------------------------------------------------------
        */

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }


        /*
        |--------------------------------------------------------------------------
        | Year
        |--------------------------------------------------------------------------
        */

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }


        /*
        |--------------------------------------------------------------------------
        | Class
        |--------------------------------------------------------------------------
        */

        if ($request->filled('class')) {

            $query->whereHas('student', function ($q) use ($request) {

                $q->where('class', $request->class);

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Section
        |--------------------------------------------------------------------------
        */

        if ($request->filled('section')) {

            $query->whereHas('student', function ($q) use ($request) {

                $q->where('section', $request->section);

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        $fees = $query
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Classes
        |--------------------------------------------------------------------------
        */

        $classes = SchoolClass::query()
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Sections
        |--------------------------------------------------------------------------
        */

        $sections = Section::query()
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Years
        |--------------------------------------------------------------------------
        */

        $years = Fee::query()
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        /*
         * Always make current year available.
         */
        if (!$years->contains(now()->year)) {
            $years->prepend(now()->year);
        }


        return view('fees.index', compact(
            'fees',
            'classes',
            'sections',
            'years'
        ));
    }


    /**
     * Take / manage monthly fees.
     */
    public function create(Request $request)
    {
        $month = (int) $request->input(
            'month',
            now()->month
        );

        $year = (int) $request->input(
            'year',
            now()->year
        );

        $selectedClass = $request->input('class');

        $selectedSection = $request->input('section');

        $defaultFee = $request->input(
            'default_fee',
            ''
        );


        /*
        |--------------------------------------------------------------------------
        | Classes
        |--------------------------------------------------------------------------
        */

        $classes = SchoolClass::query()
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Sections
        |--------------------------------------------------------------------------
        */

        $sections = collect();

        if ($selectedClass) {

            $sections = Section::query()
                ->where('class_id', $selectedClass)
                ->orderBy('name')
                ->get();
        }


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

                $studentsQuery->where(
                    'section',
                    $selectedSection
                );
            }

            $students = $studentsQuery->get();


            /*
            |--------------------------------------------------------------------------
            | Existing Fees
            |--------------------------------------------------------------------------
            */

            $existingFees = Fee::query()
                ->where('month', $month)
                ->where('year', $year)
                ->whereIn(
                    'student_id',
                    $students->pluck('id')
                )
                ->get()
                ->keyBy('student_id');


            /*
            |--------------------------------------------------------------------------
            | Attach Fee Information
            |--------------------------------------------------------------------------
            */

            $students->each(function ($student) use (
                $existingFees,
                $defaultFee
            ) {

                $fee = $existingFees->get(
                    $student->id
                );

                if ($fee) {

                    $student->fee_amount =
                        $fee->fee_amount;

                    $student->paid_amount =
                        $fee->paid_amount;

                    $student->balance =
                        $fee->balance;

                    $student->fee_status =
                        $fee->status;

                    $student->fee_due_date =
                        $fee->due_date
                            ? $fee->due_date->format('Y-m-d')
                            : null;

                    $student->fee_remarks =
                        $fee->remarks;

                } else {

                    $student->fee_amount =
                        $defaultFee !== ''
                            ? $defaultFee
                            : 0;

                    $student->paid_amount = 0;

                    $student->balance =
                        $student->fee_amount;

                    $student->fee_status =
                        $student->fee_amount > 0
                            ? 'unpaid'
                            : 'unpaid';

                    $student->fee_due_date = null;

                    $student->fee_remarks = null;
                }
            });
        }


        return view('fees.create', compact(
            'month',
            'year',
            'classes',
            'sections',
            'students',
            'selectedClass',
            'selectedSection',
            'defaultFee'
        ));
    }


    /**
     * Save monthly fees.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'month' => [
                'required',
                'integer',
                'between:1,12',
            ],

            'year' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],

            'class' => [
                'required',
                'integer',
            ],

            'section' => [
                'nullable',
                'integer',
            ],

            'fees' => [
                'required',
                'array',
            ],

            'fees.*.fee_amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'fees.*.paid_amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'fees.*.due_date' => [
                'nullable',
                'date',
            ],

            'fees.*.remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        DB::transaction(function () use ($validated) {

            foreach ($validated['fees'] as $studentId => $data) {

                $student = Student::find($studentId);

                if (!$student) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Security check
                |--------------------------------------------------------------------------
                */

                if (
                    (int) $student->class !==
                    (int) $validated['class']
                ) {
                    continue;
                }


                if (
                    !empty($validated['section']) &&
                    (int) $student->section !==
                    (int) $validated['section']
                ) {
                    continue;
                }


                $feeAmount =
                    (float) $data['fee_amount'];

                $paidAmount =
                    (float) $data['paid_amount'];


                /*
                |--------------------------------------------------------------------------
                | Don't allow payment greater than fee
                |--------------------------------------------------------------------------
                */

                $paidAmount = min(
                    $paidAmount,
                    $feeAmount
                );


                $balance =
                    max(
                        $feeAmount - $paidAmount,
                        0
                    );


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                if ($feeAmount <= 0) {

                    $status = 'unpaid';

                } elseif ($paidAmount >= $feeAmount) {

                    $status = 'paid';

                } elseif ($paidAmount > 0) {

                    $status = 'partial';

                } else {

                    $status = 'unpaid';
                }


                Fee::updateOrCreate(
                    [
                        'student_id' =>
                            $student->id,

                        'month' =>
                            $validated['month'],

                        'year' =>
                            $validated['year'],
                    ],
                    [
                        'fee_amount' =>
                            $feeAmount,

                        'paid_amount' =>
                            $paidAmount,

                        'balance' =>
                            $balance,

                        'status' =>
                            $status,

                        'due_date' =>
                            $data['due_date'] ?? null,

                        'remarks' =>
                            $data['remarks'] ?? null,
                    ]
                );
            }
        });


        return redirect()
            ->route('fees.index')
            ->with(
                'success',
                'Fees saved successfully.'
            );
    }
}