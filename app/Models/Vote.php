<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = "votes";

    protected $fillable = ['user_id', 'phone_number', 'name', 'email', 'expiry', 'code', 'is_verified'];
}
