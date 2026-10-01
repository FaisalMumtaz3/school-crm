<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'logo',
        'status',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => 'string',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(SchoolPermission::class);
    }

    public function getActivePermissions(): array
    {
        return $this->permissions()
            ->where('enabled', true)
            ->pluck('enabled', 'feature')
            ->toArray();
    }

    public function hasPermission(string $feature): bool
    {
        return $this->permissions()
            ->where('feature', $feature)
            ->where('enabled', true)
            ->exists();
    }

    public function hasAction(string $feature, string $action): bool
    {
        $permission = $this->permissions()
            ->where('feature', $feature)
            ->where('enabled', true)
            ->first();

        if (!$permission) {
            return false;
        }

        return $permission->hasAction($action);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}