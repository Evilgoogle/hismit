<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'permission_role';

    protected $fillable = ['permission_id', 'role_id'];

    public static function removeRoles($id)
    {
        DB::table('permission_role')
            ->where('role_id', $id)
            ->delete();
    }
}
