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

use App\User;
use App\Crew;
use App\Movie;

/*
Route::get('/', function () {

    
    $users = User::all();
    if ($users->count() == 0)
    {
        return view('welcome');
    }

    $crews = Crew::all();
    if ($crews->count() == 0)
    {
        return view('welcome')->with('users', $users);
    }

    $movies = Movie::all();

    if ($movies->count() == 0)
    {
        return view('welcome')->with(['users' => $users,'crews' => $crews]);
    }

    return view('welcome')->with(['users' => $users,'crews' => $crews,'movies' => $movies]);
    
});
*/

Route::get('/', 'Web\TestController@index');



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


