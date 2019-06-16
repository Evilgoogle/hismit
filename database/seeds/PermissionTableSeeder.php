<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'user-read',
                'display_name' => 'Просмотр пользователей',
                'description' => 'Просмотр списка пользователей'
            ],
            [
                'name' => 'user-create',
                'display_name' => 'Создать пользователя',
                'description' => 'Создать нового пользователя'
            ],
            [
                'name' => 'user-edit',
                'display_name' => 'Изменить пользователя',
                'description' => 'Изменить пользователя'
            ],
            [
                'name' => 'user-delete',
                'display_name' => 'Удалить пользователя',
                'description' => 'Удалить пользователя'
            ],
            [
                'name' => 'role-read',
                'display_name' => 'Просмотр ролей',
                'description' => 'Просмотр списка ролей'
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Создать роль',
                'description' => 'Создать новую роль'
            ],
            [
                'name' => 'role-edit',
                'display_name' => 'Изменить роль',
                'description' => 'Изменить роль'
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Удалить роль',
                'description' => 'Удалить роль'
            ],
        ];

        foreach ($permissions as $key => $value){
            Permission::create($value);
        }
    }
}
