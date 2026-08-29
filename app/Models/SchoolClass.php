<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';
    
    protected $fillable = [
        'name',
    ];
    public function sections(): HasMany
    {
        return $this->hasMany(
            Section::class,'class_id'
        );
    }
}
