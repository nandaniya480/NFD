<?php

namespace App\Http\Controllers\admin;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Interfaces\RoleRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Traits\WebResponseTrait;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use WebResponseTrait;

    protected $roleRepository;

    function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->middleware('role:Admin', ['only' => ['index', 'store', 'create', 'edit', 'update', 'show', 'destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->roleRepository->dataTable();
        }
        $titles = [
            'title' => 'Role List',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Role List', 'link' => false, 'route' => ''],
            ],
        ];
        return view('roles.index', compact('titles'));
    }

    public function create()
    {
        $titles = [
            'title' => 'Create Role',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Create Role', 'link' => false, 'route' => ''],
            ],
        ];
        $permission = Permission::get();
        return view('roles.create', compact('permission', 'titles'));
    }

    public function store(RoleRequest $request)
    {
        try {
            $this->roleRepository->create($request->validated());
            $msg = isset($request->id) && $request->id != null ? 'messages.custom.update_messages' : 'messages.custom.create_messages';
            return $this->sendResponse(true, ['data' => []], trans(
                $msg,
                ["attribute" => "Role"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }

    public function show($id)
    {
        $role = $this->roleRepository->find($id);
        $rolePermissions = $this->roleRepository->getPermissions($id);
        $titles = [
            'title' => 'Edit Role',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Edit Role', 'link' => false, 'route' => ''],
            ],
        ];
        return view('roles.show', compact('role', 'rolePermissions', 'titles'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = $this->roleRepository->getAllPermissions();
        $rolePermissions = $this->roleRepository->getPermissions($id)->pluck('id')->toArray();
        $titles = [
            'title' => 'Edit Role',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Edit Role', 'link' => false, 'route' => ''],
            ],
        ];
        return view('roles.edit', compact('role', 'permission', 'rolePermissions', 'titles'));
    }

    public function destroy($id)
    {
        try {
            $this->roleRepository->delete($id);

            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.delete_messages',
                ["attribute" => "Role"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }
}
