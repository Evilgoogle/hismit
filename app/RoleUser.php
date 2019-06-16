<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    protected $fillable = ['user_id', 'role_id'];

    public static function removeUser($id)
    {
        DB::table('role_user')
            ->where('user_id', $id)
            ->delete();
    }

    public static function removeRole($id)
    {
        DB::table('role_user')
            ->where('role_id', $id)
            ->delete();
    }

    public static function findUser($id)
    {
        return DB::table('role_user')
            ->where('user_id', $id)
            ->get();
    }
}
