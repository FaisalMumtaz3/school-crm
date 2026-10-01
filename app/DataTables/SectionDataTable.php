<?php

namespace App\DataTables;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionDataTable
{
    public function __construct(private readonly Request $request)
    {
    }

    public function viewData(): array
    {
        $filters = $this->request->validate([
            'search' => 'nullable|string|max:100',
        ]);

        $query = Section::query()->with('school');

        $query->when($filters['search'] ?? null, function ($q) use ($filters) {
            $q->where('name', 'like', '%' . $filters['search'] . '%');
        });

        $user = Auth::user();
        $isAdmin = $user && $user->isAdmin();

        $sections = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $columns = [
            [
                'key' => 'name',
                'label' => 'Section',
            ],

            [
                'key' => 'created_at',
                'label' => 'Created',
            ],

        ];

        if ($isAdmin) {
            array_unshift($columns, [
                'key' => 'school.name',
                'label' => 'School',
            ]);
        }

        return [
            'sections' => $sections,
            'filters' => $filters,
            'columns' => $columns,
            'isAdmin' => $isAdmin,
        ];
    }
}