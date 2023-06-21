<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =   User::create([
            'name' => 'NextFoodDelivery',
            'first_name' => 'NextFood',
            'last_name' => 'NextFood',
            'phone_number' => '1010101010',
            'email' => 'admin@email.com',
            'password' => Hash::make('Admin@123'),
        ]);

        Role::create(['name' => 'Admin']);

        $role = Role::where('name', 'Admin')->first();

        $user->assignRole([$role->id]);
    }
}
