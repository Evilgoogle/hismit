<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(NewPermissionsTableSeeder::class);
        $this->call(NewRolesTableSeeder::class);
        $this->call(NewConnectRelationshipsSeeder::class);
        $this->call(NewUsersTableSeeder::class);
        $this->call(SeosTableSeeder::class);
    }
}
