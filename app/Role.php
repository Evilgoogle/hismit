<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];

    public static function removeRole($id)
    {
        DB::table('roles')
            ->where('id', $id)
            ->delete();
    }
}
