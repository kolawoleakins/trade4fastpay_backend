<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    //
 
    use HttpResponses;



    public function sendVerifyMail($email)
    {
        // if(!auth()->user())
        // {
                    
        //     return response()->json(
        //         [
        //             "success" => false, 
        //             "message" => "User is not Authenticated"
        //         ]
        //         );

        // }

        $user = User::where('email', $email)->get();

        if(count($user) < 1)
        {
            return response()->json(
                [
                    "success" => false, 
                    "message" => "User is not found"
                ]
                );
        }

        $random = Str::random(40);

        $domain = URL::to('/');
        $url = $domain."/verify-mail/ ".$random;

        $data['url'] = $url;
        $data['email'] = $email;
        $data['title'] = "Email Verification";
        $data['body'] = "Please click to verify your mail.";
        Mail::send('verifyMail',['data'=>$data], function($message)use($data)
        {
            $message->to($data['email'])->subject($data['title']);
        });


        $user = User::find($user[0]['id']);

        $user->remember_token = $random;

        $user->save();

        return response()->json([
            "success" => true, 
            "message" => "Mail sent successfully"
        ]);


    }


    public function verifyMail($token)
    {

        $token=trim($token);

        $user = User::where('remember_token',$token)->get();


        if(count($user) < 1)
        {
            return view('404');
        }

        $user = User::find($user[0]['id']);

        $user->remember_token = '';
        $user->is_verified = 1;
        $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();


        return view('verificationSuccess');
    }



}
