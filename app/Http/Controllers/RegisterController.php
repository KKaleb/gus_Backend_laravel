<?php

namespace App\Http\Controllers;

use App\Mail\Welcome;
use App\Models\Answer;
use App\Models\Barcode;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{

    public function fullRegister(Request $request)
    {
        $request = $request->merge([
            'question_id' => json_decode($request->get('question_id')),
            'selected_value' => json_decode($request->get('selected_value'))
        ]);

        $this->validate($request, [
            'phone_number' => 'required|numeric|digits:11|unique:users',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'dob' => 'required|string',
            'age' => 'required|numeric',
            'height' => 'required|string',
            'weight' => 'required|numeric',
            'medical_challenge' => 'string',
            'address' => 'required|string',
            'state_of_origin' => 'required|string',
            'lga' => 'required|string',
            'state_of_residence' => 'required|string',
            'state_of_origin' => 'required|string',
            'name_next_of_kin' => 'required|string',
            'phone_number_next_of_kin' => 'required|numeric|digits:11',
            'relationship_next_of_kin' => 'required|string',
            'marital_status' => 'required|string',
            'gender' => 'required|string',
            'audition_location' => 'required|string',
            'bias_against_alcohol' => 'required|string',
            'hobbies' => 'required|string',
            'work' => 'required|string',
            'how_often' => 'required|string',
            'covid_19' => 'required|string',
            'covid_19_reason' => 'string',
            'video' => 'required|mimes:mp4,avi,mkv,webm,m4v,mpg,mpeg,mpv,mov,wmv,mp2,mpg,qt,flv,m4p,ogg,flv,swf,qt,mpe,avchd,3gp|max:60000',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:4024',
            'selected_value' => 'array',
            'question_id' => 'array',
            'has_medical_challenge' => 'required|string',
            'has_medical_allergies' => 'required|string',
            'medical_allergies' => 'string'
        ]);

        try{
            $transaction =  \DB::transaction(function () use ($request) {

                return response()->json(['error' => true, 'message' => 'Registration is closed'], 401);

//               if ($request->hasFile('image') && $request->hasFile('video')) {
//                   //process image
//                   $image = $request->file('image');
//                   $pictureName = (string) Str::uuid().".".$image->getClientOriginalExtension();
//                   $s3 = Storage::disk('s3');
//                   $filePath =  $pictureName;
//                   $s3->put($filePath, file_get_contents($image), 'public');
//                   $image_url =Storage::disk('s3')->url($filePath);
//
//                   //process video
//                   $video = $request->file('video');
//                   $videoFileName = (string) Str::uuid().".".$video->getClientOriginalExtension();
//                   $s3 = Storage::disk('s3');
//                   $Video_filePath =  $videoFileName;
//                   $s3->put($Video_filePath, file_get_contents($video), 'public');
//                   $video_url = Storage::disk('s3')->url($Video_filePath);
//
//                   $user = User::create([
//                    'phone_number' => $request->phone_number,
//                    'first_name' => $request->first_name,
//                    'last_name' => $request->last_name,
//                    'middle_name' => $request->middle_name,
//                    'email' => $request->email,
//                    'dob' => $request->dob,
//                    'age' => $request->age,
//                    'height' => $request->height,
//                    'weight' => $request->weight,
//                    'medical_challenge' => $request->medical_challenge,
//                    'marital_status' => $request->marital_status,
//                    'address' => $request->address,
//                    'state_of_origin' => $request->state_of_origin,
//                    'lga' => $request->lga,
//                    'state_of_residence' => $request->state_of_residence,
//                    'state_of_origin' => $request->state_of_origin,
//                    'phone_number_next_of_kin' => $request->phone_number_next_of_kin,
//                    'relationship_next_of_kin' => $request->relationship_next_of_kin,
//                    'gender' => $request->gender,
//                    'audition_location' => $request->audition_location,
//                    'how_often' => $request->how_often,
//                    'bias_against_alcohol' => $request->bias_against_alcohol,
//                    'hobbies' => $request->hobbies,
//                    'work' => $request->work,
//                    'image_url' => $image_url,
//                    'video_url' => $video_url,
//                    'name_next_of_kin' => $request->name_next_of_kin,
//                    'is_submitted' => true,
//                    'covid_19' => $request->covid_19,
//                    'covid_19_reason' => $request->covid_19_reason,
//                    'has_medical_challenge' => $request->has_medical_challenge,
//                    'has_medical_allergies' => $request->has_medical_allergies,
//                    'medical_allergies' => $request->medical_allergies
//                ]);
//
//                   $questionsIds = $request->question_id;
//                   $options = $request->selected_value;
//                   foreach ($questionsIds as $key => $value) {
//                       $getAnswer = Question::where('id', $value)->first();
//                       $data = $getAnswer->correct_answer;
//                       $user_ans = $options[$key];
//                       if($data == $user_ans){
//                           $score = true;
//                       }else{
//                           $score = false;
//                       }
//                       Answer::create([
//                           'user_id' => $user->id,
//                           'question_id' => $value,
//                           'correct_answer' => $getAnswer->correct_answer,
//                           'user_answer' => $options[$key],
//                           'is_correct' => $score
//                       ]);
//                   }
//                   $phone = '234' . substr($user->phone_number, 1);
//                   $this->notifyBySMS($phone, $user);
//                  Mail::to($user->email)->send(new Welcome($user));
//                return $user;
//                } else {
//                    return response()->json(['error' => true, 'message' => 'No image or video  detected'], 500);
//                }

            },2);
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false,'message'=>'Registration completed', 'data' => $transaction], 200);

    }


    public function notifyBySMS($phone_number, $user){
        try {
            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://termii.com/api/sms/send', [
                "api_key" => env('TERMI_API_KEY'),
                "message_type" => "NUMERIC",
                "to" => $phone_number,
                "from" => "BCToken",
                "channel" => "dnd",
                "type" => "plain",
                "sms" => "Dear Participant,Your application to participate in the Gulder Ultimate Search has been received. You will be contacted if successful.GUS Team",
            ]);

        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        $response = json_decode($res->getBody()->getContents(), true);
        return $response;
    }


    public function showBarcodes()
    {
        try{
            $show = Barcode::all();
            $data['abuja'] = $show->where('audition_location', 'Abuja')->count();
            $data['lagos'] = $show->where('audition_location', 'Lagos')->count();
            $data['enugu'] = $show->where('audition_location', 'Enugu')->count();
            $data['barcodes'] = $show;
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => true, 'message' => 'Barcode', 'data' => $data], 200);
    }


    public function applicantBarcode()
    {
        try{
            $user = User::with('barcode')->where('is_admin', false)
                ->where('status', 'ACCEPTED')->get();
            //$data['count'] = $user->count();
            //$data['user'] = $user;
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'User barcode', 'data' =>$user], 200);
    }

    public function applicantBarcodeAbuja()
    {
        try{
            $user = User::with('barcode')->where('is_admin', false)
                ->where('status', 'ACCEPTED')->where('audition_location', 'Abuja')->get();
            $data['count'] = $user->count();
            $data['user'] = $user;
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Abuja Applicants', 'data' =>$data], 200);
    }
    public function applicantBarcodeLagos()
    {
        try{
            $user = User::with('barcode')->where('is_admin', false)
                ->where('status', 'ACCEPTED')->where('audition_location', 'Lagos')->get();
            $data['count'] = $user->count();
            $data['user'] = $user;
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Lagos Applicants', 'data' =>$data], 200);
    }

    public function applicantBarcodeEnugu()
    {
        try{
            $user = User::with('barcode')->where('is_admin', false)
                ->where('status', 'ACCEPTED')->where('audition_location', 'Enugu')->get();
            $data['count'] = $user->count();
            $data['user'] = $user;
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Lagos Applicants', 'data' =>$data], 200);
    }

    public function contestantList()
    {
        
        try{
            $selectedContestant = User::where('select_constant', 'SELECTED')->get(['id', 'first_name', 'middle_name', 'last_name', 'image_url']);
            foreach ($selectedContestant as $key => $contestant) {
                $contestant->is_contestant = true; //(isset($selectedContestant)) ? true : false; //(isset($options[$key]))?$options[$key]: null,
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message' => 'Selected Contestants', 'data' => $selectedContestant], 200);
    }
    

}
