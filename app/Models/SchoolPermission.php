<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'feature',
        'enabled',
        'actions',
        'settings',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'actions' => 'array',
        'settings' => 'array',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public static function availableFeatures(): array
    {
        return [
            'students' => 'Student Management',
            'teachers' => 'Teacher Management',
            'classes' => 'Class Management',
            'sections' => 'Section Management',
            'attendance' => 'Attendance Management',
            'fees' => 'Fee Management',
            'reports' => 'Reports',
        ];
    }

    public static function availableActions(): array
    {
        return [
            'view' => 'View',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
        ];
    }

    public function getActions(): array
    {
        $defaults = array_keys(self::availableActions());
        return $this->actions ?? array_fill_keys($defaults, true);
    }

    public function hasAction(string $action): bool
    {
        if (!$this->enabled) {
            return false;
        }

        $actions = $this->getActions();
        return $actions[$action] ?? false;
    }

    public function setAction(string $action, bool $value): void
    {
        $actions = $this->getActions();
        $actions[$action] = $value;
        $this->actions = $actions;
        $this->save();
    }
}