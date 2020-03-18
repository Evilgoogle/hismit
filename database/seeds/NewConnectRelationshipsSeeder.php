<?php

use Illuminate\Database\Seeder;

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
        $roleAdmin = \App\Role::where('slug', '=', 'admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }
    }
}
