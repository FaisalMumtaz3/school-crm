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
        $query = Section::with('schoolClass');


        /*
         * Search Section or Class
         */
        if (!empty($filters['search'])) {

            $search = $filters['search'];

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                );

                $q->orWhereHas(
                    'schoolClass',
                    function ($classQuery) use ($search) {

                        $classQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );

                    }
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
                'key' => 'schoolClass.name',
                'label' => 'Class',
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
