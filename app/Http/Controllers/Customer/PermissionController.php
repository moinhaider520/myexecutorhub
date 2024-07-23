<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function showAssignPermissionsForm(Request $request)
    {
        $roles = Role::whereIn('name', [ 'Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers'])->get();
        $permissions = Permission::all();
        
        $assignedPermissions = [];
        if ($request->has('role')) {
            $role = Role::findByName($request->role);
            $assignedPermissions = $role->permissions->pluck('name')->toArray();
        }

        return view('customer.assign_permissions', compact('roles', 'permissions', 'assignedPermissions'));
    }

    public function assignPermissions(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'array|exists:permissions,name',
        ]);

        $role = Role::findByName($request->role);
        $role->syncPermissions($request->permissions);

        return redirect()->route('customer.assign_permissions_form', ['role' => $request->role])->with('success', 'Permissions assigned successfully!');
    }
}
