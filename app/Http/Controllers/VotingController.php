<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\DateTime;
use App\Models\NewVote;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\TypeResolver;

class VotingController extends Controller
{
    public function index()
    {
        try{
            $applicants = User::where('voting_enrol', true)->withCount(['votes'])->get();
            $applicantstotalVotes = NewVote::where('code', null)->count(); //this count all the rows that doesn't have a code assigned
            foreach ($applicants as $key => $user) {
                $voteCount = NewVote::where('user_id', $user->id)->count();
                $user->vote_percentage = number_format($voteCount / $applicantstotalVotes * 100, 1);
            }
            }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'data' => $applicants], 200);
    }

    public function highestVote()
    {
        try{
            $highestVotes = User::where('voting_enrol', true)->withCount(['votes'])->orderBy('votes_count', 'desc')->take(2)->get();
            $totalVotes = NewVote::where('code', null)->count(); //this count all the rows that doesn't have a code assigned
            foreach ($highestVotes as $key => $user) {
                $voteCount = NewVote::where('user_id', $user->id)->count();
                $user->vote_percentage = number_format($voteCount / $totalVotes * 100, 1);
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'data' => $highestVotes], 200);
    }

    public function vote(Request $request)
    {
        $this->validate($request, [
            //'user_id' => 'required|uuid',
            //'phone_number' => 'required|numeric|digits:11',
            'email' => 'required|email',
            'name' => 'required|string'
        ]);

        try{
//            $verifyUser = User::where('id', $request->user_id)->where('voting_enrol', true)->where('status', 'ACCEPTED')->first();
//            if(is_null($verifyUser)){
//                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
//            }
            $checkPhoneNumber = NewVote::where('email', $request->email)->where('is_verified', false)->first();
            $checkPhoneNumber_true = NewVote::where('email', $request->email)->where('is_verified', true)->first();

//            return $checkPhoneNumber;
            if($checkPhoneNumber_true)
            {
                $message = 'email already verified, redirect to cast vote url';
                $data = null;
                return response()->json(['error' => false, 'is_verified' => true, 'status_code' => 200, 'message' => $message], 200);
            }
            if(is_null($checkPhoneNumber))
            {
                $message = 'Email not registered, CODE send';
                $res = false;
                $code = rand(100,1000000); //Str::random(5);
                $currentTime = Carbon::now()->addDay();
                $data = NewVote::create(['user_id' => $request->user_id,'phone_number' => $request->phone_number,'name' => $request->name, 'email' => $request->email,
                    'code' => $code, 'expiry'=>$currentTime]);
                Mail::to($request->email)->send(new EmailVerification($request->email, $request->name, $code));

//                $phone = '234'.substr($request->phone_number, 1);
//                $generate_otp_response = $this->generateOTP($phone); //generates otp
//                if ($generate_otp_response['status'] != "success") {
//                    throw new \Exception("something went wrong otp cannot be generated. Try again", 500);
//                }
//                $otp = $generate_otp_response['data']['otp'];
//                $data =  $this->sendOTP($phone, $otp); //sends otp to phone number
            } else{
                $message = 'email exist, redirect to cast vote url';
                $res = true;
                $data = null;
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'is_available' => $res, 'status_code' => 200, 'message' => $message, 'data' => $data ], 200);
    }

    public function verifyCode(Request $request)
    {
        $this->validate($request, [
            //'user_id' => 'required|uuid',
            'name' => 'required|string',
            //'phone_number' => 'required|numeric|digits:11',
            'email' => 'required|email',
            'code' => 'required|string'
        ]);

        try{
            $verify = NewVote::where('code', $request->code)->first();
            if(is_null($verify)){
                return response()->json(['error' => true, 'message' => 'code invalid'], 401);
            }
            if($verify->is_verified == true){
                return response()->json(['error' => true, 'message' => 'code already verified'], 401);
            }
            $verify->is_verified = true;
            $verify->save();
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'code verified'], 200);
    }

    public function castVote(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|uuid',
            'name' => 'required|string',
            //'phone_number' => 'required|numeric|digits:11',
            'email' => 'required|email',
        ]);

        try{
            return response()->json(['error' => true, 'message' => 'Voting has ended'], 401);
//            $veryfyUser = User::where('id', $request->user_id)->first();
//            if(is_null($veryfyUser)){
//                return response()->json(['error' => true, 'message' => 'user is invalid'], 401);
//            }
//            $checkEmail = NewVote::where('email', $request->email)->where('is_verified', true)->first();
//            if(is_null($checkEmail)){
//                return response()->json(['error' => true, 'message' => 'email invalid'], 401);
//            }
//
//            $todayRecord = NewVote::where('email', $request->email)->where('is_verified', true)
//                ->where('code', null)->whereDate('created_at', Carbon::today())->count();
////            $todayRecord = Vote::where('phone_number', $request->phone_number)->where('user_id', $request->user_id)
////                ->whereDate('created_at', Carbon::today())->count();
//            if($todayRecord >= '2'){
//                return response()->json(['error' => true, 'message' => 'You have exhausted your votes'], 401);
//            }else{
//                NewVote::create(['user_id' => $request->user_id, 'phone_number' => $request->phone_number, 'name' => $request->name,
//                    'email' => $request->email, 'is_verified' => true]);
//            }
//
//            $voteCasted = NewVote::where('email', $request->email)->where('is_verified', true)
//                ->where('code', null)->whereDate('created_at', Carbon::today())->count();
//            $votesRemaining = 2 - $voteCasted;

        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'vote recorded'], 200);
    }


    public function generateOTP($phone)
    {
        try {
            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://termii.com/api/sms/otp/generate', [
                "api_key" => env('TERMI_API_KEY'),
                "pin_type" => "NUMERIC",
                "phone_number" => $phone,
                "pin_attempts" => 3,
                "pin_time_to_live" => 60,
                "pin_length" => 4
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        $response = json_decode($res->getBody()->getContents(), true);
        return $response;
    }

    public function sendOTP($phone, $otp)
    {
        try {
            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://termii.com/api/sms/otp/send', [
                "api_key" => env('TERMI_API_KEY'),
                "message_type" => "NUMERIC",
                "to" => $phone,
                "from" => "BCToken",
                "channel" => "dnd",
                "pin_attempts" => 10,
                "pin_time_to_live" => 60,
                "pin_length" => 6,
                "pin_placeholder" => "< $otp >",
                "message_text" => "Your TopBrain authorization is < $otp >. It expires in 60 minutes",
                "pin_type" => "NUMERIC"
            ]);

        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        return $response = json_decode($res->getBody()->getContents(), true);
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'pin_id' => 'required|string',
            'otp' => 'required|string'
        ]);

        try{
            $verifyOTP = $this->verifyOTP($request->pin_id, $request->otp);
            $data = $verifyOTP['verified'];

            if($data === false)
            {
                $code = '400';
            }elseif($data === 'Expired'){
                $code = '400';
            }else{
                $code = '200';
            }

        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['status' => true, 'message'=>'Phone Number Verified', 'data' => $verifyOTP],  $code);
    }

    public function verifyOTP($pin, $otp)
    {
        try{
            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://termii.com/api/sms/otp/verify', [
                "api_key" => env('TERMI_API_KEY'),
                "pin_id"=> $pin,
                "pin"=> $otp
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
       return  $response = json_decode($res->getBody()->getContents(), true);
    }

    public function getVoteCount(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        try{
            $voteCasted = NewVote::where('email', $request->email)->where('is_verified', true)
                ->where('code', null)->whereDate('created_at', Carbon::today())->count();
            $votesRemaining = 2 - $voteCasted;

        }catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message'=>'Number of vote', 'data' => $votesRemaining],  200);
    }

    public function createStartDate(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date'
        ]);

        try{
            $endDate = Carbon::parse($request->start_date)->addHour(24);
            DateTime::UpdateOrCreate(['start_date' => $request->start_date, 'end_date' => $endDate]);
        }catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message'=>'Date Created'],  200);
    }

    public function getDateTime()
    {
        try{
            $getDate = DateTime::all();
            $currentDate = Carbon::now();
            $data['date'] = $getDate;
            $data['current_time'] = $currentDate;
        }catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'data'=>$data],  200);
    }


}
