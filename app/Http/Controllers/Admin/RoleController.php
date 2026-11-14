<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])->orderBy('id')->get();
        $totalPermissions = Permission::count();

        return view('admin.roles.index', compact('roles', 'totalPermissions'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('group_label');

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => 'Nama peran (role) wajib diisi.',
            'name.unique' => 'Nama peran ini sudah ada.',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_system' => false,
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', "Peran baru '{$role->name}' berhasil dibuat dengan " . count($validated['permissions'] ?? []) . " hak akses.");
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::all()->groupBy('group_label');
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('roles')->ignore($role->id)],
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => 'Nama peran wajib diisi.',
            'name.unique' => 'Nama peran ini sudah digunakan.',
        ]);

        $roleData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ];

        // Do not change slug for system roles like super-admin
        if (!$role->is_system) {
            $roleData['slug'] = Str::slug($validated['name']);
        }

        $role->update($roleData);

        // If Super Admin, automatically ensure all permissions are granted
        if ($role->is_system && $role->slug === 'super-admin') {
            $allPermIds = Permission::pluck('id')->toArray();
            $role->syncPermissions($allPermIds);
        } else {
            $role->syncPermissions($validated['permissions'] ?? []);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', "Peran '{$role->name}' dan matriks hak akses berhasil diperbarui.");
    }

    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return back()->with('error', "Peran sistem '{$role->name}' bersifat permanen dan tidak dapat dihapus.");
        }

        $userCount = $role->users()->count();
        if ($userCount > 0) {
            return back()->with('error', "Peran '{$role->name}' masih digunakan oleh {$userCount} pengguna aktif. Mohon ubah peran pengguna tersebut terlebih dahulu.");
        }

        $roleName = $role->name;
        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', "Peran '{$roleName}' berhasil dihapus.");
    }
}

