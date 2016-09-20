<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use JWTAuth;
use Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {        
    	$input = $request->only('email', 'password');
        
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json(['error' => 'validation error']);
        }

    	$input['password'] = Hash::make($input['password']);
    	User::create($input);
        return response()->json(['result'=>true]);
    }
    
    public function login(Request $request)
    {
    	$input = $request->only('email', 'password');
        
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            $errors = $validator->errors();

            $arrayErrors = array();

            foreach ($errors->all() as $message)
            {
                $arrayErrors = array_add(['error' => $message]);
            }
            return response()->json($arrayErrors);
        }

    	if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['result' => 'wrong email or password.']);
        }
        	return response()->json(['result' => $token]);
    }
    
    public function get_user_details(Request $request)
    {
    	$input = $request->all();
    	$user = JWTAuth::toUser($input['token']);
        return response()->json(['result' => $user]);
    }   
}
