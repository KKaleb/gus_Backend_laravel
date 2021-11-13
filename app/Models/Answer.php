<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model{

    protected $table = "answers";

    protected $fillable = ['user_id', 'question_id', 'correct_answer', 'user_answer', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
