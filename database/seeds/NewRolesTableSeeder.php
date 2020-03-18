<?php

use Illuminate\Database\Seeder;

class NewRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Админ',
                'slug'        => 'admin',
                'description' => 'Полный доступ к функционалу',
                'level'       => 5,
            ],
            [
                'name'        => 'Пользователь',
                'slug'        => 'user',
                'description' => 'Добавленный пользователь, имеет полный доступ к клиентской части сайта',
                'level'       => 1,
            ],
            [
                'name'        => 'Демо-пользователь',
                'slug'        => 'demo',
                'description' => 'Добавленный пользователь, имеет доступ к ограниченному функционалу клиентской части сайта',
                'level'       => 0,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = \App\Role::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = \App\Role::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
            }
        }
    }
}
