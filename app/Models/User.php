<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'school_id',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSchoolAdmin(): bool
    {
        return $this->role === 'school_admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function canAccessSchool(?int $schoolId): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isSchoolAdmin()) {
            return $this->school_id === $schoolId;
        }

        return false;
    }

    public function hasSchoolPermission(string $feature): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (!$this->school) {
            return false;
        }

        return $this->school->hasPermission($feature);
    }

    public function hasSchoolAction(string $feature, string $action): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (!$this->school) {
            return false;
        }

        return $this->school->hasAction($feature, $action);
    }
}