<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('school')
            ->when(!Auth::user()->isAdmin(), function ($query) {
                $query->where('school_id', Auth::user()->school_id);
            })
            ->latest()
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $schools = Auth::user()->isAdmin() ? School::where('status', 'active')->get() : collect();
        $roles = ['school_admin', 'staff'];

        return view('users.create', compact('schools', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:school_admin,staff',
            'school_id' => 'required_if:role,school_admin,staff|exists:schools,id',
            'is_active' => 'boolean',
        ]);

        $user = Auth::user();
        if (!$user->isAdmin()) {
            $validated['school_id'] = $user->school_id;
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorizeSchoolAccess($user->school_id);

        $schools = Auth::user()->isAdmin() ? School::where('status', 'active')->get() : collect();
        $roles = ['school_admin', 'staff'];

        return view('users.edit', compact('user', 'schools', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeSchoolAccess($user->school_id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:school_admin,staff',
            'school_id' => 'required_if:role,school_admin,staff|exists:schools,id',
            'is_active' => 'boolean',
        ]);

        $admin = Auth::user();
        if (!$admin->isAdmin()) {
            $validated['school_id'] = $admin->school_id;
            unset($validated['role']); // Non-admin can't change roles
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorizeSchoolAccess($user->school_id);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    private function authorizeSchoolAccess(?int $schoolId): void
    {
        $user = Auth::user();

        if (!$user->canAccessSchool($schoolId)) {
            abort(403, 'Unauthorized access to this school\'s users.');
        }
    }
}