<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewVote extends Model
{
    protected $table = "new_votes";

    protected $fillable = ['user_id', 'phone_number', 'name', 'email', 'expiry', 'code', 'is_verified'];
}
