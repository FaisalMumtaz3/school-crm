<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'class_id');
    }
}
