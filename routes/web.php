<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', function () {
    //return view('welcome');
    return 'MovieCrew Home TEST';
});



Route::get('/login', function () {
    return view('auth/login');
})->name('login');;

Route::post('/login', 'Web\Auth\AuthController@login');

Route::get('/register', function () {
    return view('auth/register');
})->name('register');;

Route::post('/register', 'Web\Auth\AuthController@register');

Route::post('/logout', 'Web\Auth\AuthController@logout');

Route::group(['middleware' => ['auth']], function () 
{
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    /*Route::get('/adminpanel', function () {
        $user = Auth::user();
        if (Gate::forUser($user)->allows('view_admin_panel')) {
            // User is Admin, redirect to AdminPanel.
            return view('admin/adminpanel');
        }
        // User is NOT an Admin, redirect to Dashboard.
        return redirect('dashboard')->with('error','User is Not an Admin');
    });
    */
});


