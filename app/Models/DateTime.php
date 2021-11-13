<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateTime extends Model
{
    protected $table = "date_time";

    protected $fillable = ['start_date', 'end_date'];
}
