<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'subscribers';

    protected $fillable = [
        'email'
    ];
}
