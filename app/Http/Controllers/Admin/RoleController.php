<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
