<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\StoreRoleRequest;
use App\Http\Requests\Admin\Roles\UpdateRoleRequest;
use App\Models\Role;
use App\Traits\RestTrait;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use RestTrait;

    public function index()
    {
        $roles = Role::tableFilter()->get();

        if (request()->ajax()) {
            return $this->sendResponse(view('admin.roles.table')->with('roles', $roles)->render());
        }

        return view('admin.roles.index')->with('roles', $roles);
    }

    public function create()
    {
        $role = null;
        $permissions = Permission::all()->groupBy('group_name');

        return view('admin.roles.edit')
            ->with('permissions', $permissions)
            ->with('role', $role);
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();

        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);

        if (isset($data['permissions']) && count($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $this->sendResponse($role, t('role added successfully'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('group_name');

        return view('admin.roles.edit')
            ->with('permissions', $permissions)
            ->with('role', $role);
    }


    public function update(Role $role, UpdateRoleRequest $request)
    {
        $data = $request->validated();

        $role->update([
            'name' => $data['name'],
        ]);

        if (isset($data['permissions']) && count($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        } else {
            $role->syncPermissions([]);
        }

        return $this->sendResponse($role, t('role updated successfully'));
    }
}
