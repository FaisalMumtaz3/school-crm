<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\SchoolScope;

class Teacher extends Model
{
    use HasFactory, SchoolScope;

    protected $fillable = [
        'school_id',
        'name',
        'father_name',
        'phone',
        'qualification',
        'subject',
        'salary',
        'joining_date',
        'contract_start_date',
        'contract_end_date',
    ];

    protected function casts(): array
    {
        return [
            'salary' => 'decimal:2',
            'joining_date' => 'date',
            'contract_start_date' => 'date',
            'contract_end_date' => 'date',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}