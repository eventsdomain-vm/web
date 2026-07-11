<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('admin.roles', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $validated['name']]);

        if (! empty($validated['permissions'])) {
            $role->permissions()->attach($validated['permissions']);
        }

        $this->logActivity(
            'role_created',
            "Role '{$role->name}' created",
            null,
            ['role_name' => $role->name, 'permissions' => $validated['permissions'] ?? []]
        );

        return redirect()->route('admin.roles')
            ->with('success', 'Role created successfully!');
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->permissions()->sync($validated['permissions'] ?? []);

        $this->logActivity(
            'role_updated',
            "Role '{$role->name}' updated",
            null,
            ['role_name' => $role->name, 'permissions' => $validated['permissions'] ?? []]
        );

        return redirect()->route('admin.roles')
            ->with('success', 'Role updated successfully!');
    }
}
