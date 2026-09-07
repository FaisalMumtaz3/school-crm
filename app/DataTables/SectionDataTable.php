<?php

namespace App\DataTables;

use App\Models\Section;

class SectionDataTable
{
    public function viewData()
    {
        /*
         * Filters
         */
        $filters = [
            'search' => request('search'),
        ];


        /*
         * Query
         */
        $query = Section::query();


        /*
         * Search Section
         */
        if (!empty($filters['search'])) {

            $search = $filters['search'];

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                );

            });
        }


        /*
         * IMPORTANT:
         * paginate() is required because
         * SectionDataTable.blade.php uses:
         *
         * $sections->total()
         * $sections->hasPages()
         * $sections->links()
         */
        $sections = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
         * Columns
         */
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


        /*
         * Send everything to Blade
         */
        return [
            'sections' => $sections,
            'filters' => $filters,
            'columns' => $columns,
        ];
    }
}
