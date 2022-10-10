<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::tableFilter()->get();

        if (request()->ajax()) {
            return $this->sendResponse(view('admin.users.table')->with('users', $users)->render());
        }

        return view('admin.users.index')->with('users', $users);
    }

    public function create()
    {
        $user = null;
        $roles = Role::get();
        return view('admin.users.edit')
            ->with('roles', $roles)
            ->with('user', $user);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'] ?? 12345678),

        ]);

        if (isset($data['roles']) && count($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $this->sendResponse($user, t('user added successfully'));
    }

    public function edit(User $user)
    {
        $roles = Role::get();
        return view('admin.users.edit')
            ->with('roles', $roles)
            ->with('user', $user);
    }


    public function update(User $user, UpdateUserRequest $request)
    {
        $data = $request->validated();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'] ?? 12345678),

        ]);

        if (isset($data['roles']) && count($data['roles'])) {
            $user->syncRoles($data['roles']);
        } else {
            $user->syncRoles([]);
        }

        return $this->sendResponse($user, t('user updated successfully'));
    }
}
