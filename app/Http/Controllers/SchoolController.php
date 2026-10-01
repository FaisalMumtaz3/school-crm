<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Models\SchoolPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::withCount(['users', 'students', 'teachers'])->latest()->paginate(15);

        return view('schools.index', compact('schools'));
    }

    public function create()
    {
        return view('schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:schools,code',
            'email' => 'required|email|max:255|unique:schools,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        $school = School::create($validated);

        // Create school admin user
        User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'school_id' => $school->id,
            'role' => 'school_admin',
            'is_active' => true,
        ]);

        // Create default permissions for the school
        foreach (SchoolPermission::availableFeatures() as $feature => $label) {
            SchoolPermission::create([
                'school_id' => $school->id,
                'feature' => $feature,
                'enabled' => true,
                'actions' => array_fill_keys(array_keys(SchoolPermission::availableActions()), true),
            ]);
        }

        return redirect()->route('schools.index')
            ->with('success', 'School created successfully with admin account.');
    }

    public function show(School $school)
    {
        $school->load(['users', 'students', 'teachers', 'classes', 'permissions']);
        return view('schools.show', compact('school'));
    }

    public function edit(School $school)
    {
        $school->load('permissions');
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:schools,code,' . $school->id,
            'email' => 'required|email|max:255|unique:schools,email,' . $school->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $school->update($validated);

        // Update permissions (feature-level enabled/disabled)
        if ($request->has('permissions')) {
            foreach ($request->input('permissions', []) as $feature => $enabled) {
                SchoolPermission::updateOrCreate(
                    ['school_id' => $school->id, 'feature' => $feature],
                    ['enabled' => (bool) $enabled]
                );
            }
        }

        // Update action-level permissions
        if ($request->has('actions')) {
            foreach ($request->input('actions', []) as $feature => $actions) {
                $permission = SchoolPermission::firstOrCreate(
                    ['school_id' => $school->id, 'feature' => $feature],
                    ['enabled' => true, 'actions' => array_fill_keys(array_keys(SchoolPermission::availableActions()), false)]
                );
                $currentActions = $permission->getActions();
                foreach ($actions as $action => $value) {
                    $currentActions[$action] = (bool) $value;
                }
                $permission->actions = $currentActions;
                $permission->save();
            }
        }

        return redirect()->route('admin.schools.index')
            ->with('success', 'School updated successfully.');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('admin.schools.index')
            ->with('success', 'School deleted successfully.');
    }

    public function permissions(School $school)
    {
        $school->load('permissions');
        $features = SchoolPermission::availableFeatures();

        return view('schools.permissions', compact('school', 'features'));
    }

    public function updatePermissions(Request $request, School $school)
    {
        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'boolean',
            'actions' => 'array',
        ]);

        // Update feature-level permissions
        foreach (SchoolPermission::availableFeatures() as $feature => $label) {
            SchoolPermission::updateOrCreate(
                ['school_id' => $school->id, 'feature' => $feature],
                ['enabled' => $validated['permissions'][$feature] ?? false]
            );
        }

        // Update action-level permissions
        if ($request->has('actions')) {
            foreach ($request->input('actions', []) as $feature => $actions) {
                $permission = SchoolPermission::firstOrCreate(
                    ['school_id' => $school->id, 'feature' => $feature],
                    ['enabled' => true, 'actions' => array_fill_keys(array_keys(SchoolPermission::availableActions()), false)]
                );
                $currentActions = $permission->getActions();
                foreach ($actions as $action => $value) {
                    $currentActions[$action] = (bool) $value;
                }
                $permission->actions = $currentActions;
                $permission->save();
            }
        }

        return redirect()->route('admin.schools.permissions', $school)
            ->with('success', 'Permissions updated successfully.');
    }
}