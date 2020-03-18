<?php

namespace App;

use App\Notifications\MailResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use Notifiable, HasRoleAndPermission/*, SoftDeletes*/;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'name', 'email', 'password', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    /**
     *
     * protected $dates = [
     *   'deleted_at'
     *];
    */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    /*
     * Получение всех пользователей кроме админа
     */
    public static function getAllUsersNotAdmin()
    {
        $role = Role::where('slug', 'admin')->first();

        return DB::table('users as u')
            ->select('u.*', 'r.name as role_name')
            ->leftJoin('role_user as ru', 'ru.user_id', '=', 'u.id')
            ->leftJoin('roles as r', 'r.id', '=', 'ru.role_id')
            ->where('ru.role_id', '!=', $role->id)
            ->get();
    }

    /*
     * Проверка на существование email
     */
    public static function checkEmail($email)
    {
        return DB::table('users')
            ->select('id')
            ->where('email', $email)
            ->count();
    }
}
