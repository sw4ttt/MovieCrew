<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;
use JWTAuth;
use Validator;

use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{

    public function register(Request $request)
    {        
    	$input = $request->only('email', 'name','password','password_confirmation');
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            //return response()->json($validator->errors());
            return back()->withErrors($validator)->withInput($input);

        }

    	$input['password'] = Hash::make($input['password']);

    	User::create([
            'name' => $input['name'],
           'email' => $input['email'],
           'password' => $input['password']
       ]);

        //return response()->json(['result'=>true]);
        return redirect('login');  
    }
    
    public function login(Request $request)
    {
    	$input = $request->only('name','email', 'password');
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            
            //return response()->json($validator->errors());

            return back()->withErrors($validator)->withInput($input);
        }

        $email = $request->input('email');
        $password = $request->input('password');

    	if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
            $user = Auth::user();
            if (Gate::forUser($user)->allows('view_admin_panel')) {
                // The user can do things...
                return redirect('adminpanel');
            }
            return redirect('dashboard');
        }

        //return redirect('login');

        return redirect('login')->with('error','Wrong Credentials.');   
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');    	
    }
}
