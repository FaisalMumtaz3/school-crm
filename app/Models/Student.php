<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\SchoolScope;

class Student extends Model
{
    use HasFactory, SchoolScope;

    protected $fillable = [
        'school_id',
        'name',
        'father_name',
        'phone',
        'class',
        'section',
        'roll_number',
        'admission_date'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class');
    }

    public function studentSection(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }
}