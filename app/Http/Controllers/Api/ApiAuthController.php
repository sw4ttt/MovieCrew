<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function signup(Request $request)
    {
        $signupFields = [
            'name', 'email', 'password'
            ];
        $signupFieldRules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
            ];  

        $hasToReleaseToken = true;

        $userData = $request->only($signupFields);

        $validator = Validator::make($userData, $signupFieldRules);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        User::unguard();
        $user = User::create($userData);
        User::reguard();

        if(!$user->id) {
            return $this->response->error('could_not_create_user', 500);
        }

        if($hasToReleaseToken) {
            return $this->login($request);
        }
        
        return $this->response->created();
    }
}
