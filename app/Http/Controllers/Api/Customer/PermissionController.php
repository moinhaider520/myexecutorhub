<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function getRolesAndPermissions(Request $request)
    {
        $roles = Role::whereIn('name', ['Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers'])->get();
        $permissions = Permission::all();

        $assignedPermissions = [];
        if ($request->has('role')) {
            $role = Role::findByName($request->role);
            $assignedPermissions = $role->permissions->pluck('name')->toArray();
        }

        return response()->json([
            'roles' => $roles,
            'permissions' => $permissions,
            'assigned_permissions' => $assignedPermissions,
        ], 200);
    }

    public function assignPermissions(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'role' => 'required|exists:roles,name',
                'permissions' => 'required|array|exists:permissions,name',
            ]);

            // Find the role case-insensitively
            $role = Role::where('name', $validated['role'])->first();
            if (!$role) {
                return response()->json([
                    'error' => 'Role does not exist.'
                ], 404);
            }

            // Sync permissions
            $role->syncPermissions($validated['permissions']);

            return response()->json([
                'message' => 'Permissions assigned successfully!',
                'role' => $role->name,
                'permissions' => $role->permissions->pluck('name'),
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // validation error response
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // general error response for any other exception
            return response()->json([
                'error' => 'An error occurred while assigning permissions.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
