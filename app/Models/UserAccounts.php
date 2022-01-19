<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccounts extends Model
{
    use HasFactory;

    function userRepositories()
    {
        return $this->hasMany('App\Models\UserRepositories','user_account_id','id');
    }
}
