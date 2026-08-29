<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SchoolClass;
use App\Models\Section;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'father_name',
        'phone',
        'class',
        'section',
        'roll_number',
        'admission_date'
    ];
   public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class');
    }

    public function studentSection(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
