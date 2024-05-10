<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Country;
use App\State;
use App\SsDocument;
use App\Subscription;
use App\User;
use Otp;
use DB; 
use Carbon\Carbon; 
use Mail; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Mail\ForgotTwofaMail;

class CommonsController extends Controller
{

    public function verify(Request $request){
        
        $email_verified = Auth::user()->email_verified;
        if($email_verified == 1){
            return redirect('/investor/dashboard');
        }else{
            return view("auth.verify");
        }
    }

    public function denied(Request $request){
     
        return view("auth.denied");
    }

    public function landing(Request $request){
        
        $user_id = Auth::user()->id;
        $subscription = Subscription::where('user_id',$user_id)->orderBy('created_at', 'ASC')->first();
        if(!empty($subscription)){
            if($subscription['status'] == 0){

                return redirect('/investor/subscriptionCreate');
            }else if( ($subscription['status'] == 2) || ($subscription['status'] == 3) || ($subscription['status'] == 6) || ($subscription['status'] == 7)){

                return redirect('/investor/dashboard');
            }
        }

        return view("auth.landing");
    }
    
    public function checkEmailExist(Request $request){
        
        $user = User::where('email',$request->get('email'))->first();

        if(empty($user)){
            
            return response()->json(['valid' => true], 201);
        }else{
            return response()->json(['valid' => false], 201);
        }
    }

    public function checkLoginCredentials(Request $request){
        
        $user = User::where('email',$request->get('email'))->first();

        if(!empty($user)){
            if (!(Hash::check($request->get('password'), $user->password))) {
                $gauth = false;
                return response()->json(['data' => "Wrong Credentials", "error" => 1, "gauth" => $gauth], 201);
            }else{
                if($user["2fa_status"] == 1){
                    $gauth = true;
                }else{
                    
                    $otp = new Otp();
                    $otp = $otp->generate($user->email, 6, 15);
    
                    $to = $user['mobile_prefix'].$user['mobile_no'];
                    $msg = __('oal.sms_message', ['otp' => $otp->token]);
                    $userModel = new User();
                    $userModel->sendOtp($to, $msg);
                    
                    $gauth = false;
                }
                return response()->json(['data' => "success", "error" => 0, "gauth" => $gauth], 201);
            }    
        }else{
            $gauth = false;
            return response()->json(['data' => "Wrong Credentials", "error" => 1, "gauth" => $gauth], 201);
        }
    }

    public function resendOtp(Request $request){
        
        $user = User::where('email',$request->get('email'))->first();

        if(!empty($user)){
            if (!(Hash::check($request->get('password'), $user->password))) {
                return response()->json(['data' => "Wrong Credentials", "error" => 1], 201);
            }else{

                $otp = new Otp();
                $otp = $otp->generate($user->email, 6, 15);

                $to = $user['mobile_prefix'].$user['mobile_no'];
                $msg = __('oal.sms_msg', ['otp' => $otp->token]);
                $userModel = new User();
                $userModel->sendOtp($to, $msg);

                return response()->json(['data' => "success", "error" => 0], 201);
            }    
        }else{
            return response()->json(['data' => "Wrong Credentials", "error" => 1], 201);
        }
    }


    public function otpCheck(Request $request){
        
        $user = User::where('email',$request->get('email'))->first();

        if(!empty($user)){

            $otp = new Otp();
            $otp = $otp->validate($user->email, $request->get('otp'));

            if($otp->status){
                return response()->json(['data' => "success", "error" => 0], 201);
            }else{
                return response()->json(['data' => "Wrong Credentials", "error" => 1], 201);
            }
        }else{
            return response()->json(['data' => "Wrong Credentials", "error" => 1], 201);
        }
    }

    public function gaotpCheck(Request $request){
        
        $user = User::where('email',$request->get('email'))->first();

        if(!empty($user)){
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($user['2fa_key'], $request->get('otp'), 2);
            if ($valid) {
                return response()->json(['data' => "success", "error" => 0], 201);
            }else{
                return response()->json(['data' => "Wrong Credentials", "error" => 1], 201);
            }
        }else{
            return response()->json(['data' => "Wrong Credentials", "error" => 1], 201);
        }
    }

    public function registerOtpCheck(Request $request){
        
        $google2fa_secret = $request->get('secretcode');
        $google2fa_otp = $request->get('code');

        if(!empty($google2fa_otp)){
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($google2fa_secret, $google2fa_otp, 2);
            if ($valid) {
                return response()->json(['data' => "success", "error" => 0], 201);
            }else{
                return response()->json(['data' => "Wrong Credentials", "error" => 1], 201);
            }
        }else{
            return response()->json(['data' => "Wrong Credentials", "error" => 1], 201);
        }
    }

	public function state(Request $request){
		$country_id =$request->input('country_id');
        $states = State::where('country_id',$country_id)->pluck('name', 'id')->toArray();

        return response()->json([
			    'data' => $states
			], 201);        
    }


    public function ssdocumentUpload(Request $request){

    	$subscription_id = $request->session()->get('subscription_id');
    	$main_type = $request->input('main_type');
    	$sub_type = $request->input('sub_type');

    	$originalImage= $request->file('file');
        if(!empty($originalImage)){
			
			$fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $originalImage->storeAs('ssattachment', $fileName, 'public');

 			$image_name = $filePath;
        }else{
            $image_name = "";
        }

        if(!empty($subscription_id)){

        	$requestData = $request->all();
	        $requestData['subscription_id'] = $subscription_id;
	        $requestData['main_type'] = $main_type;
	        $requestData['sub_type'] = $sub_type;
	        $requestData['file'] = $image_name;
	        $requestData['remarks'] = $request->input('remarks');

        	$ssDocumentData = SsDocument::where(['subscription_id' => $subscription_id, 'main_type' => $main_type, 'sub_type' => $sub_type])->first();

        	if(!empty($ssDocumentData)){

	            $ssDocument = SsDocument::find($ssDocumentData->id);
	            $ssDocument->update($requestData);
	        }else{

	            $ssDocument = SsDocument::create($requestData);
	        }	
	    }

        return response()->json(['data' => "success"], 201);        
    }

    public function ssdocumentRemove(Request $request){

    	$subscription_id = $request->session()->get('subscription_id');
    	$main_type = $request->input('main_type');
    	$sub_type = $request->input('sub_type');

    	$ssDocumentData = SsDocument::where(['subscription_id' => $subscription_id, 'main_type' => $main_type, 'sub_type' => $sub_type])->first();

		if(!empty($ssDocumentData)){
			$id = $ssDocumentData->id;
			SsDocument::find($id)->delete();

			return response()->json(['data' => "success".$subscription_id], 201);     
		}else{

			return response()->json(['data' => "error".$ssDocumentData."---".$subscription_id."--".$main_type."--".$sub_type], 201);     
		}      
    }

    public function sSupportDocumentUpload(Request $request){

        $subscription_id = $request->session()->get('subscription_id');
        $sub_type = $request->input('sub_type');

        if($SupportDocs=$request->file('file')){
            foreach ($SupportDocs as $doc) {
                
                $ext = $doc->extension();
                // $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $valid_ext = array("png","jpeg","jpg", "pdf");

                if(in_array($ext, $valid_ext)){

                    $ssAttachment = new SsDocument;

                    $fileName = time().'_'.$doc->getClientOriginalName();
                    $filePath = $doc->storeAs('ssattachment', $fileName, 'public');
                    $ssAttachment->file = $filePath;
                    $ssAttachment->main_type = 1;
                    $ssAttachment->sub_type = $sub_type;
                    $ssAttachment->subscription_id = $subscription_id;
                    $ssAttachment->remarks = "";

                    $ssAttachment->save();

                } else {
                    return response()->json(['data' => "error" , 'message' => "File format not supported!"], 201);    
                }
            }
        }

        return response()->json(['data' => "success"], 201);

        // $countfiles = count($_FILES['file']['name']);
        // $sub_type = $request->input('sub_type');

        // Loop all files
        // for($index = 0; $index < $countfiles; $index++){

        //     if(isset($_FILES['file']['name'][$index]) && $_FILES['file']['name'][$index] != ''){
        //         // File name
        //         $filename = $_FILES['file']['name'][$index];

        //         $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        //         $valid_ext = array("png","jpeg","jpg");

        //         if(in_array($ext, $valid_ext)){

        //             $ssAttachment = new SsDocument;

        //             $fileName = time().'_'.$filename->getClientOriginalName();
        //             $filePath = $filename->storeAs('ssattachment', $fileName, 'public');
        //             $ssAttachment->file = $filePath;
        //             $ssAttachment->main_type = 1;
        //             $ssAttachment->sub_type = $sub_type;
        //             $ssAttachment->subscription_id = $subscription_id;
        //             $ssAttachment->remarks = "";

        //             $ssAttachment->save();

        //         } else {

        //         }
        //     }

        // }

    }
    
    public function sessionCheckingLogin(Request $request) {

        if (\Auth::user()){

            $userId = Auth::user()->id;
            $session_date = Session::get('datetime');

            if(!empty($session_date)){
                $datetime1 = date('Y-m-d H:i:s', strtotime($session_date));
                $datetime2 = date('Y-m-d H:i:s');

                $seconds = strtotime($datetime2) - strtotime($datetime1);

                $days    = floor($seconds / 86400);
                $hours   = floor(($seconds - ($days * 86400)) / 3600);
                $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

                $min = $days * 24 * 60;
                $min += $hours * 60;
                $min += $minutes;

                if($min < 30){

                    return response()->json(['data' => "true"], 201);
                } else {
                    return response()->json(['data' => "false"], 201);
                }
            }

        } else {
            return response()->json(['data' => "true"], 201);
        }
    }

    public function sessionRelogin(Request $request)
    {
        if (\Auth::user()){
            $request->session()->regenerate(true);

            return redirect()->back()->with("success","Re-login Successfully!!!");
        } else {
            return redirect()->back()->with("error","Your login token was expired, can`t re-login!!!");
        }
    }

    public function sessionLogout(Request $request)
    {
        if (auth()->user()){

            @Auth::logout();
            $request->session()->flush();
            return response()->json(['status' => 1], 201);  
        }else{
            return response()->json(['status' => 0], 201);  
        }
    }

    public function reset2Fa(Request $request) {
        
        // return $request->all();

        $userEmail = $request->userEmail;
        $verifyToken = DB::table('twofa_resets')->where(['email' => $userEmail, 'token' => $request->token])->first();

        if(!$verifyToken){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $User = User::where('email', $userEmail)->first();
        if(!empty($User)){
            if (!empty($request->code)) {
                
                $secret = $request->secretcode;
                $oneCode = $request->code;

                $google2fa = app('pragmarx.google2fa');
                $valid = $google2fa->verifyKey($secret, $oneCode, 2); // 2 = 2*30sec clock tolerance
                if ($valid) {
                    $requestData['2fa_key'] =  $secret;
                    $requestData['2fa_status'] = 1;

                    $User->update($requestData);

                    //delete token
                    DB::table('twofa_resets')->where(['email'=> $userEmail])->delete();

                    // return redirect()->back()->with("success", "2Fa reset successfully!");
                    return redirect('/login')->with("success", "2Fa reset successfully!");

                }else {
                    return redirect('/login')->with('error', 'Wrong code entered. Please try again.');
                }

                return redirect('/login')->with('error', 'Something went wrong. Please try again.');
            }
        } else {
            return redirect('/login')->with('error', "We can't find a user with that email address.");
        }
    }

    public function forgot2Fa(Request $request){
        
        $user = User::where('email',$request->get('userEmail'))->first();
        if(!empty($user)){
            
            $token = Str::random(64);
  
            DB::table('twofa_resets')->insert([
                'email' => $request->userEmail, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
            
            //Email Save
            $objData = new \stdClass();
            $objData->email = $request->userEmail;
            $objData->name = $user->name;
            $objData->salutation = $user->salutation;
            $objData->link = "";
            $objData->token = $token;
            $to_email = $request->userEmail;

            $email_status = config('settings.email_sent');
            if ($email_status == 1) {
                Mail::to($to_email)->send(new ForgotTwofaMail($objData));
            }

            // Mail::send('emails.forget2FaPassword', ['token' => $token], function($message) use($request){
            //     $message->to($request->userEmail);
            //     $message->subject('Reset 2FA Authentication');
            // });

            return redirect()->back()->with('success', 'We have e-mailed your 2FA reset link!');

        }else{
            return redirect('/login')->with('error', "We can't find a user with that email address.");
        }
    }

    public function resetTwofa($token) {

        @$userEmail = DB::table('twofa_resets')->where('token', $token)->first(['email'])->email;
        if(!empty($userEmail)){

            $google2fa = app('pragmarx.google2fa');
            $google2fa_secret = $google2fa->generateSecretKey();

            $qr_image = $google2fa->getQRCodeInline(
                config('app.name'),
                rand(),
                $google2fa_secret
            );

            return view('auth.forgetTwofaLink', [
                'google2fa_secret' => $google2fa_secret,
                'qr_image' => $qr_image,
                'token' => $token,
                'userEmail' => $userEmail
            ]);

        } else {
            return redirect('/login')->with('error', "Invalid request to access this page.");
        }

        // return view('auth.forgetTwofaLink', ['token' => $token]);
    }
        
}
