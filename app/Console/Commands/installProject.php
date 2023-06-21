<?php

namespace App\Console\Commands;

use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class installProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Project to migrate, seed, and create super admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $userRepository = "";
    protected $roleRepository = "";

    function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->runMigrations();
        $this->runSeeders();
        $this->createSuperAdmin();
    }

    private function runMigrations()
    {
        $confirmation = $this->ask('Do you want to run migrations? Yes/No', 'No');
        if (strtolower($confirmation) === "yes" || strtolower($confirmation) === "y") {
            $this->call('migrate:fresh');
        }
    }

    private function runSeeders()
    {
        $confirmation = $this->ask('Do you want to run seeders? Yes/No', 'No');
        if (strtolower($confirmation) === "yes" || strtolower($confirmation) === "y") {
            $this->call('db:seed', ['--class' => 'RoleSeeder']);
            $this->call('db:seed', ['--class' => 'PermissionTableSeeder']);
            $this->call('db:seed', ['--class' => 'AdminPermissionsSeeder']);
        }
    }

    private function createSuperAdmin()
    {
        $userFirstName = $this->ask('Provide first name ');
        $userLastName = $this->ask('Provide last name ');
        $email = $this->ask('Provide email ');
        $password = $this->ask('Provide password ');

        $responseMessage = $this->createSuperAdminFun([
            'first_name' => $userFirstName,
            'last_name' => $userLastName,
            'email' => $email,
            'password' => $password,
        ]);

        if ($responseMessage['status']) {
            foreach ($responseMessage['message'] as $message) {
                $this->info($message);
                $this->newLine();
            }
        } else {
            foreach ($responseMessage['message'] as $message) {
                $this->error($message);
                $this->newLine();
            }
        }
    }

    public function createSuperAdminFun($userDetail)
    {
        $validator = Validator::make($userDetail, [
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return ['message' => $validator->errors()->all(), 'status' => 0];
        }

        $data = $this->userRepository->createUser($userDetail);
        if ($data) {
            $role = $this->roleRepository->findByName('Admin');
            $data->assignRole([$role->id]);
            return ['message' => [trans('messages.custom.super_admin_messages')], 'status' => 1];
        }
    }
}
