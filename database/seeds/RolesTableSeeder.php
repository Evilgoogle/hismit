<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'superadmin',
                'display_name' => 'Суперадмин',
                'description' => 'Полный доступ к функционалу'
            ],
            [
                'name' => 'user',
                'display_name' => 'Пользователь',
                'description' => 'Добавленный пользователь, имеет доступ только к личному кабинету. Роль присваивается автоматически.'
            ],
        ];

        foreach ($roles as $key => $value){
            Role::create($value);
        }
    }
}
