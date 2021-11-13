<?php

namespace App\Http\Controllers;



use App\Http\Resources\QuestionResource;
use App\Http\Resources\UserResource;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function getQuestions()
    {
        try{
            $questionList = Question::orderBy('created_at')->get(['id', 'questions', 'opt_A', 'opt_B', 'opt_C', 'opt_D']); //all()->get(['id'])->random(2);
            $questions = $questionList->random(3);
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json($questions, 200);
    }

    public function submitQuestions(Request $request)
    {
        $this->validate($request, [
            'selected_value' => 'required|array',
            'question_id' => 'required|array',
            'user_id' => 'required|uuid'
        ]);

        try{
            $questionsIds = $request->question_id;
            $options = $request->selected_value;
            foreach ($questionsIds as $key => $value) {
                $getAnswer = Question::where('id', $value)->first();
                $data = $getAnswer->correct_answer;
                $user_ans = $options[$key];
                if($data == $user_ans){
                    $score = true;
                }else{
                    $score = false;
                }

                Answer::create([
                    'user_id' => $request->user_id,
                    'question_id' => $value,
                    'correct_answer' => $getAnswer->correct_answer,
                    'user_answer' => $options[$key],
                    'is_correct' => $score
                ]);
                //$count += $score;
             }

            //return $count;
            }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }

        return response()->json(['error' => false, 'video_upload_url' => true, 'message' => 'answer saved'], 200);

    }
}
