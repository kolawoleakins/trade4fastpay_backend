<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    //

    use HttpResponses;

    //method to login user
    public function login(LoginUserRequest $request)
    {
        //check if all the fields are valid . 
        $request->validated($request->all());

        //returns a failed response when the email does not 
        //match the password . 
        if(!Auth::attempt($request->only('email','password')))
        {
            return $this->failed('','Credentials do not match any user', 401);
        }


        $user = User::where('email', $request->email)->first();

        //return an unauthorized when an email is not verified 
        if($user->is_verified === 0)
        {
            return $this->failed("","Email not verified",401);
        }

        return $this->success(
            [
                'user' => $user, 
                'token' => $user->createToken('Api Token of'. $user->name)->plainTextToken
            ]
            );

    }


    //method to register new users
    public function register(StoreUserRequest $request)
    {
        //validating the form field
        $request->validated($request->all());

        //creating a new user after the filed 
        //has been validated
        $user = User::create(
            [
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name, 
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]
            );

            return $this->success(
                [
                    "message" => "user registration was successful", 
                    "verify mail at" => "localhost/api/send-verify-mail/{$user->email}",
                ]
                );

        // return $this->success(
        //     [
        //         'user' => $user, 
        //         'token' => $user->createToken('Api Token of'. $user->name)->plainTextToken
        //     ]
        //     );


    }


    public function logout() 
    {

        if(Auth::user()->currentAccessToken())
        {
            Auth::user()->currentAccessToken()->delete();
        }
        return $this->success(
            [
                'message' => 'You have successfully been logged out and your token has been deleted',
            ]
            );  
    }


    public function forgotPassword() 
    {

    }


    public function resetPassword()
    {

    }
}
