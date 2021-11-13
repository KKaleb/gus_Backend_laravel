<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $table = "question";

    protected $fillable = ['id', 'questions', 'opt_A', 'opt_B', 'opt_C', 'opt_D', 'correct_answer'];
}
