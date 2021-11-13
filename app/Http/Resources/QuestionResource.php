<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class QuestionResource extends JsonResource
{
    public function toArray($questions)
    {
        return $questions;
//        return [
////            'id' => $this->id,
////            'questions' => $this->questions
//        ];
    }
}
