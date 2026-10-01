<?php

namespace App\DataTables;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDataTable
{
    public function __construct(private readonly Request $request) {}

    public function viewData(): array
    {
        $filters = $this->request->validate([
            'search' => 'nullable|string|max:100',
            'subject' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
        ]);

        $teachersQuery = Teacher::query()->with('school');

        $teachersQuery->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($teacherQuery) use ($search) {
                $teacherQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('qualification', 'like', "%{$search}%");
            });
        });

        $teachersQuery->when($filters['subject'] ?? null, fn ($query, $subject) => $query->where('subject', $subject));
        $teachersQuery->when($filters['qualification'] ?? null, fn ($query, $qualification) => $query->where('qualification', $qualification));

        $user = Auth::user();
        $isAdmin = $user && $user->isAdmin();

        return [
            'teachers' => $teachersQuery->latest()->paginate(10)->withQueryString(),
            'subjects' => Teacher::query()
                ->when(!$isAdmin && $user->school_id, fn ($q) => $q->where('school_id', $user->school_id))
                ->whereNotNull('subject')
                ->distinct()
                ->orderBy('subject')
                ->pluck('subject'),
            'qualifications' => Teacher::query()
                ->when(!$isAdmin && $user->school_id, fn ($q) => $q->where('school_id', $user->school_id))
                ->whereNotNull('qualification')
                ->distinct()
                ->orderBy('qualification')
                ->pluck('qualification'),
            'filters' => $filters,
            'isAdmin' => $isAdmin,
        ];
    }
}