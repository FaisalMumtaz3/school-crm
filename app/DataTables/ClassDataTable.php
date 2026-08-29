<?php

namespace App\DataTables;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassDataTable
{
    public function __construct(private readonly Request $request)
    {
    }

    public function viewData(): array
    {
        $filters = $this->request->validate([
            'search' => 'nullable|string|max:100',
        ]);

        $classesQuery = SchoolClass::query();

        $classesQuery->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        });

        return [
            'classes' => $classesQuery->latest()->paginate(10)->withQueryString(),
            'filters' => $filters,
            'columns' => $this->columns(),
        ];
    }

    // This is the single source of truth for fields displayed in the class table.
    public function columns(): array
    {
        return [
            ['key' => 'name', 'label' => 'Class'],
        ];
    }
}
