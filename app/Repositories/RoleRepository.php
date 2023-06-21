<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleRepository implements RoleRepositoryInterface
{
    public function dataTable()
    {
        $data = Role::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('action', function ($row) {
                $btn =  '<div class="v-button"><a href="' . route('roles.show', $row->id) . '" class="btn"><i class="menu-icon tf-icons ti ti-solid ti-eye"></i></a>';
                $btn .=  '<a href="' . route('roles.edit', $row->id) . '" class="btn" ><i class="menu-icon tf-icons ti ti-solid ti-pencil"></i></a>';
                $btn .= '<button class="btn deleteRole" data-id="' . $row->id . '" data-action="' . route('roles.destroy', $row->id) . '" ><i class="menu-icon tf-icons ti ti-solid ti-trash"></i></button></div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function all()
    {
        return Role::pluck('name')->all();
    }

    public function create($data)
    {
        $role = isset($data['id']) && $data['id'] != null ? Role::find($data['id']) : new Role();
        $role->name = $data['name'];
        $role->save();
        $role->syncPermissions($data['permission']);
        return $role;
    }

    public function delete($id)
    {
        Role::destroy($id);
    }

    public function find($id)
    {
        return Role::find($id);
    }

    public function findByName($roleName)
    {
        return Role::where('name', $roleName)->first();
    }

    public function getPermissions($id)
    {
        return Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }
}
