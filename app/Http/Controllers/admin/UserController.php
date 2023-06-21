<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Traits\WebResponseTrait;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use WebResponseTrait;

    protected $userRepository;
    protected $roleRepository;

    function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->middleware('role:Admin', ['only' => ['index', 'store', 'create', 'edit', 'update', 'show', 'destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->userRepository->all();
        }
        $titles = [
            'title' => 'User List',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'User List', 'link' => false, 'route' => ''],
            ],
        ];
        return view('users.index', compact('titles'));
    }

    public function create()
    {
        $roles = $this->roleRepository->all();
        $titles = [
            'title' => 'Create User',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Create User', 'link' => false, 'route' => ''],
            ],
        ];
        return view('users.create', compact('roles', 'titles'));
    }

    public function store(UserRequest $request)
    {
        try {
            $this->userRepository->createWebUser($request->validated());
            $msg = isset($request->id) && $request->id != null ? 'messages.custom.update_messages' : 'messages.custom.create_messages';
            return $this->sendResponse(true, ['data' => []], trans(
                $msg,
                ["attribute" => "User"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = $this->userRepository->findUserById($id);
        $titles = [
            'title' => 'User Detail',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'User Detail', 'link' => false, 'route' => ''],
            ],
        ];
        return view('users.show', compact('user', 'titles'));
    }

    public function edit($id)
    {
        $user = $this->userRepository->findUserById($id);
        $roles = $this->roleRepository->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $titles = [
            'title' => 'Edit User',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Edit User', 'link' => false, 'route' => ''],
            ],
        ];
        return view('users.edit', compact('user', 'roles', 'userRole', 'titles'));
    }

    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.delete_messages',
                ["attribute" => "User"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }
}
