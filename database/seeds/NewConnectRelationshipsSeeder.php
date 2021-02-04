<?php

use Illuminate\Database\Seeder;
use App\Role;

class NewConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions.
         */
        $permissions = config('roles.models.permission')::all();

        /**
         * Attach Permissions to Roles.
         */
        $roleAdmin = Role::where('slug', '=', 'admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }
    }
}
