<?php

namespace App\Http\Controllers;


use App\Helpers\PaginationHelper;
use App\Http\Resources\UserResource;
use App\Mail\AcceptApplicant;
use App\Mail\Welcome;
use App\Models\Answer;
use App\Models\Barcode;
use App\Models\User;
use Doctrine\Foo\Bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Storage;
use Illuminate\Support\Str;
use \Milon\Barcode\DNS1D;

class NewAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validateToken(Request $request)
    {
        return new UserResource($request->user());
    }

    public function viewApplicants()
    {
        try{
            $users = User::where('is_admin', false)->paginate(10);
            foreach ($users as $key => $user) {
                $user->is_contestant = ($user->select_constant == 'SELECTED') ? true : false;
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'All Submitted Applicants', 'data' => $users], 200);
    }

    public function applicantFilter(Request $request)
    {
        $this->validate($request, [
            'search' => 'required|string'
        ]);

        try{
            $search =\DB::table('users')->where('is_admin', false)->where('phone_number', $request->search)->paginate(10);
            //orWhere('phone_number', 'LIKE', "%{$request->search}%")->paginate(10); //User::where('is_admin', false)->orWhere('phone_number', 'LIKE', "%{$request->search}%")->paginate(10);
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'result', 'data' => $search], 200);
    }

    public function acceptApplicant($id)
    {
        try{
            $user = User::where('id', $id)->first();
            if(is_null($user))
            {
                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
            }

//            $auditionLocation = $user->audition_location;
//            $checkBarcode = Barcode::where('audition_location', $auditionLocation)->where('is_assigned', false)->orderBy('id', 'desc')->first();
//            if(empty($checkBarcode)){
//                return response()->json(['error' => true, 'message' => 'Barcode exhausted for '.$auditionLocation], 401);
//            }
//            $barcode = $checkBarcode->barcode_url;

            $user->status = 'ACCEPTED';
            $user->save();

//            $checkBarcode->is_assigned = true;
//            $checkBarcode->user_id = $user->id;
//            $checkBarcode->save();
//
//            $phone = '234'.substr($user->phone_number, 1);
//            $message = "Congratulations! You have been shortlisted for the next stage of the screening exercise which is the regional selection. Kindly check your registered email for more information";
//
//            //set address of audition location
//            if($auditionLocation == 'Abuja'){
//                $address = 'The Practice Pitch, Moshood Abiola Stadium, FCT';
//                $date = 'September 14, 2021';
//                $assignedBarcode = Barcode::where('audition_location', $auditionLocation)->where('is_assigned', true)->count();
//                if($assignedBarcode <= 75){
//                    $batch = '1';
//                    $time = '8:30 AM';
//                }elseif($assignedBarcode <= 150){
//                    $batch = '2';
//                    $time = '10:30 AM';
//                }elseif ($assignedBarcode <= 225){
//                    $batch = '3';
//                    $time = '12:30 PM';
//                }else{
//                    $batch = '4';
//                    $time = '2:30 PM';
//                }
//                $checkBarcode->time = $time;
//                $checkBarcode->batch = $batch;
//                $checkBarcode->save();
//
//            }elseif ($auditionLocation == 'Lagos'){
//                $address = 'National Stadium, Surulere';
//                $date = 'September 16, 2021';
//                $assignedBarcode = Barcode::where('audition_location', $auditionLocation)->where('is_assigned', true)->count();
//                if($assignedBarcode <= 75){
//                    $batch = '1';
//                    $time = '8:30 AM';
//                }elseif($assignedBarcode <= 150){
//                    $batch = '2';
//                    $time = '10:30 AM';
//                }elseif ($assignedBarcode <= 225){
//                    $batch = '3';
//                    $time = '12:30 PM';
//                }else{
//                    $batch = '1';
//                    $time = '2:30 PM';
//                }
//                $checkBarcode->time = $time;
//                $checkBarcode->batch = $batch;
//                $checkBarcode->save();
//
//            }else{
//
//                $address = 'Nnamdi Azikiwe Stadium, Ogui road, Enugu';
//                $date = 'September 15, 2021';
//                $assignedBarcode = Barcode::where('audition_location', $auditionLocation)->where('is_assigned', true)->count();
//                if($assignedBarcode <= 75){
//                    $batch = '1';
//                    $time = '8:30 AM';
//                }elseif($assignedBarcode <= 150){
//                    $batch = '2';
//                    $time = '10:30 AM';
//                }elseif ($assignedBarcode <= 225){
//                    $batch = '3';
//                    $time = '12:30 PM';
//                }else{
//                    $batch = '4';
//                    $time = '2:30 PM';
//                }
//                $checkBarcode->time = $time;
//                $checkBarcode->batch = $batch;
//                $checkBarcode->save();
//            }
//            $this->notifyApplicantBySMS($phone, $message);
//            Mail::to($user->email)->send(new AcceptApplicant($user, $barcode, $address, $time, $batch, $date));

        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'applicant accepted'], 200);
    }

    public function rejectApplicant($id)
    {
        try{
            $user = User::where('id', $id)->first();
            if(is_null($user))
            {
                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
            }
            $user->status = 'REJECTED';
            $user->save();

        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'applicant rejected'], 200);
    }

    public function notifyApplicantBySMS($phone, $message)
    {
        try {
            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://termii.com/api/sms/send', [
                "api_key" => env('TERMI_API_KEY'),
                "message_type" => "NUMERIC",
                "to" => $phone,
                "from" => "BCToken",
                "channel" => "dnd",
                "type" => "plain",
                "sms" => $message,
            ]);

        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        $response = json_decode($res->getBody()->getContents(), true);
        return $response;
    }


    public function showApplicant($id)
    {
        try{
            $user = User::with(['answers'])->where('id', $id)->first();
            $user['is_contestant'] = ($user->select_constant == 'SELECTED') ? true : false;
            if(is_null($user))
            {
                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'applicant information', 'data' => $user], 200);
    }

    public function watchApplicantVideo($id)
    {
        try{
            $user = User::where('id', $id)->first();
            if(is_null($user))
            {
                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'applicant video', 'video_url' => $user->video_url], 200);
    }

    public function viewPendingApplicants()
    {
        try{
            $pendingApplicants = User::where('status', 'PENDING')->where('is_admin', false)->orderBy('created_at', 'DESC')->paginate(10);
            //dd(\request()->query());
        }catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Pending Applicants','data' =>$pendingApplicants], 200);
    }

    public function viewAcceptedApplicants()
    {
        try{
            $acceptedApplicants = User::where('status', 'ACCEPTED')->where('is_admin', false)->orderBy('created_at', 'DESC')->paginate(10);
        }catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Accepted Applicants','data' =>$acceptedApplicants], 200);
    }

    public function viewRejectedApplicants()
    {
        try{
            $rejectedApplicants = User::where('status', 'REJECTED')->where('is_admin', false)->orderBy('created_at', 'DESC')->paginate(10);
        }catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Rejected Applicants','data' =>$rejectedApplicants], 200);
    }

    public function dataCount()
    {
        try{
            $users = User::all();
            $data['all_applicant'] = $users->where('is_admin', false)->count();
            $data['pending_applicant'] = $users->where('is_admin', false)->where('status', 'PENDING')->count();
            $data['accepted_applicant'] = $users->where('is_admin', false)->where('status', 'ACCEPTED')->count();
            $data['rejected_applicant'] = $users->where('is_admin', false)->where('status', 'REJECTED')->count();
        }catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Data count','data' =>$data], 200);
    }

    public function uploadBarcode(Request $request)
    {
        $this->validate($request, [
            'audition_location' => 'required|string',
            'image' => 'required',
        ]);

        try{
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $upload_image)
                {
                    $original_name = $upload_image->getClientOriginalName();
                    $pictureName = $original_name . "." . $upload_image->getClientOriginalExtension();
                    $s3 = Storage::disk('s3');
                    $filePath = $pictureName;
                    $s3->put($filePath, file_get_contents($upload_image), 'public');
                    $image_url = Storage::disk('s3')->url($filePath);

                    $data['audition_location'] = $request->audition_location;
                    $data['barcode_url'] = $image_url;
                    Barcode::create($data);
                }
            }else{
                return response()->json(['error' => true, 'message' => 'Image not valid'], 401);
            }
            }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Barcode Uploaded'], 200);
    }

    public function filterByAge($age)
    {
        try{
            $filterByAge = User::where('age', $age)->get();
            foreach($filterByAge as $key => $user) {
                $user->is_contestant = ($user->select_constant == 'SELECTED') ? true : false;
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Filter By Age', 'data' =>$filterByAge], 200);
    }

    public function filterByAuditionLocation($location)
    {
        try{
            $filterByAuditionLocation = User::where('audition_location', $location)->get();
            foreach ($filterByAuditionLocation as $key => $user) {
                $user->is_contestant = ($user->select_constant == 'SELECTED') ? true : false;
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Filter By Audition Location', 'data' =>$filterByAuditionLocation], 200);
    }

    public function filterByGender($gender)
    {
        try{
            $filterByGender = User::where('gender', $gender)->get();
            foreach ($filterByGender as $key => $user) {
                $user->is_contestant = ($user->select_constant == 'SELECTED') ? true : false;
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Filter By Gender', 'data' =>$filterByGender], 200);
    }

    public function filterByHeight($height)
    {
        try{
            $filterByHeight = User::where('height', $height)->get();
            foreach ($filterByHeight as $key => $user) {
                $user->is_contestant = ($user->select_constant == 'SELECTED') ? true : false;
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message'=>'Filter By Height', 'data' =>$filterByHeight], 200);
    }

    public function enroleApplicatForVoting(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|uuid',
           // 'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:4024',
        ]);

        try{
            $data = User::where('id', $request->user_id)->where('status', 'ACCEPTED')->first();
            if(is_null($data))
            {
                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
            }
            $data->voting_enrol = true;
            $data->save();
//            if ($request->hasFile('image')) {
//                //process image
//                $image = $request->file('image');
//                $pictureName = (string)Str::uuid() . "." . $image->getClientOriginalExtension();
//                $s3 = Storage::disk('s3');
//                $filePath = $pictureName;
//                $s3->put($filePath, file_get_contents($image), 'public');
//                $image_url = Storage::disk('s3')->url($filePath);
//
//                $data->image_url = $image_url;
//                $data->voting_enrol = true;
//                $data->save();
//            }else{
//                return response()->json(['error' => true, 'message' => 'Image is not valid'], 401);
//            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message' => 'Applicant Successfully enrolled for voting'], 200);
    }

    public function unenrolApplicantForVoting(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|uuid'
        ]);

        try{
            $data = User::where('id', $request->user_id)->first();
            if(is_null($data))
            {
                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
            }
            $data->voting_enrol = false;
            $data->save();
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message' => 'Applicant Successfully removed from Voting List'], 200);
    }

    public function selectContestant(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|uuid',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:4024',
            'bio' => 'required|string'
        ]);

        try{
            $selectContestant = User::where('id', $request->user_id)->first();
            if(is_null($selectContestant))
            {
                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
            }

            if ($request->hasFile('image')) {
                //process image
                $image = $request->file('image');
                $pictureName = (string)Str::uuid() . "." . $image->getClientOriginalExtension();
                $s3 = Storage::disk('s3');
                $filePath = $pictureName;
                $s3->put($filePath, file_get_contents($image), 'public');
                $image_url = Storage::disk('s3')->url($filePath);

                $selectContestant->image_url = $image_url;
                $selectContestant->select_constant = 'SELECTED';
                $selectContestant->bio = $request->bio;
                $selectContestant->save();
            }else{
                return response()->json(['error' => true, 'message' => 'Image is not valid'], 401);
            }


        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message' => 'Contestant Selected'], 200);
    }

    public function deSelectContestant(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|uuid'
        ]);

        try{
            $deSelectContestant = User::where('id', $request->user_id)->first();
            if(is_null($deSelectContestant))
            {
                return response()->json(['error' => true, 'message' => 'user invalid'], 401);
            }
            if($deSelectContestant->select_constant != 'SELECTED'){
                return response()->json(['error' => true, 'message' => 'contestant was not selected before'], 401);
            }
            $deSelectContestant->select_constant = 'DE-SELECTED';
            $deSelectContestant->save();
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message' => 'Contestant Removed'], 200);
    }

    public function displaySelectedContestant()
    {
        try{
            $selectedContestant = User::where('select_constant', 'SELECTED')->get();
            foreach ($selectedContestant as $key => $contestant) {
                $contestant->is_contestant = true; //(isset($selectedContestant)) ? true : false; //(isset($options[$key]))?$options[$key]: null,
            }
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message' => 'Selected Contestants', 'data' => $selectedContestant], 200);
    }

    public function displayDeSelectedContestant()
    {
        try{
            $deSelectedContestant = User::where('select_constant', 'DE-SELECTED')->get();
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' =>false, 'message' => 'Selected Contestants', 'data' => $deSelectedContestant], 200);
    }

}
