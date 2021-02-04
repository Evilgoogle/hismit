<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class NewUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $userRole = Role::where('slug', '=', 'user')->first();
        $adminRole = Role::where('slug', '=', 'admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        if (User::where('email', '=', 'admin@default.loc')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Admin',
                'email'    => 'admin@default.loc',
                'password' => bcrypt('123456'),
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

/*        if (User::where('email', '=', 'irolik90@gmail.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'User',
                'email'    => 'irolik90@gmail.com',
                'password' => bcrypt('12345678'),
            ]);

            $newUser;
            $newUser->attachRole($userRole);
        }*/
    }
}
