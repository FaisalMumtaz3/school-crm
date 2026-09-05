<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'month',
        'year',
        'fee_amount',
        'paid_amount',
        'balance',
        'status',
        'due_date',
        'remarks',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'fee_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}