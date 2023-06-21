<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserRepository implements UserRepositoryInterface
{
    public function createUser($request)
    {
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request);
        return $user;
    }

    public function createWebUser($request)
    {
        if (isset($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        }

        if (isset($request['role'])) {
            $role = $request['role'];
            unset($request['role']);
        }

        $user = User::updateOrCreate([
            'id' => !isset($request['id']) ? 0 : $request['id'],
        ], $request);

        if (isset($role)) {
            $user->assignRole($role);
        }
        return $user;
    }

    public function all()
    {
        $data = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('action', function ($row) {
                $btn =  '<div class="v-button"><a href="' . route('users.show', $row->id) . '" class="btn"><i class="menu-icon tf-icons ti ti-solid ti-eye"></i></a>';
                $btn .=  '<a href="' . route('users.edit', $row->id) . '" class="btn" ><i class="menu-icon tf-icons ti ti-solid ti-pencil"></i></a>';
                $btn .= '<button class="btn deleteUser" data-id="' . $row->id . '" data-action="' . route('users.destroy', $row->id) . '" ><i class="menu-icon tf-icons ti ti-solid ti-trash"></i></button></div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function findUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function findUserById($id)
    {
        return User::find($id);
    }

    public function updateUser($id, $data)
    {
        $user = $this->findUserById($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function logout($userId)
    {
        return User::where('id', $userId)->update(array('device_token' => null, 'access_token' => null, 'updated_at' => now()));
    }

    public function getUserData()
    {
        return Auth::user();
    }

    public function delete($id)
    {
        User::destroy($id);
    }
}
