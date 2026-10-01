<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait SchoolScope
{
    protected static function bootSchoolScope(): void
    {
        static::addGlobalScope('school', function (Builder $builder) {
            $user = Auth::user();

            if (!$user) {
                return;
            }

            if ($user->isAdmin()) {
                return;
            }

            if ($user->school_id) {
                $builder->where('school_id', $user->school_id);
            }
        });
    }

    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    public function scopeWithoutSchoolScope($query)
    {
        return $query->withoutGlobalScope('school');
    }
}