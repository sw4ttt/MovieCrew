<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/
/*
Route::group(['middleware' => ['api','cors'],'prefix' => 'api'], function () {
    Route::post('register', 'Api\ApiAuthController@register');
    Route::post('login', 'Api\ApiAuthController@login');
    Route::group(['middleware' => 'jwt-auth'], function () {
    	Route::post('get_user_details', 'Api\ApiAuthController@get_user_details');
    });
});
*/

//https://moviecrew.herokuapp.com/api/login?email=&password=boner123

Route::group(['middleware' => ['api','cors']], function () 
{
    // Grupo Normal
    Route::post('register', 'Api\Auth\AuthController@register');
    Route::post('login', 'Api\Auth\AuthController@login');

    // USERS Routes
    Route::post('deleteuser', 'Api\UserController@delete');
    Route::get('getusers', 'Api\UserController@index');    
    
    // CREWS Routes
    Route::get('crews', 'Api\CrewController@index');
    Route::post('addcrew', 'Api\CrewController@addCrewToUser');
    Route::post('createcrew', 'Api\CrewController@store');
    Route::post('getcrewuser', 'Api\CrewController@showCrewUser');
    Route::post('getusercrews', 'Api\CrewController@showUserCrews');
    Route::post('deletecrew', 'Api\CrewController@delete');

    // MOVIES Routes
    Route::get('movies', 'Api\MoviesController@index');
    Route::post('getMovie', 'Api\MoviesController@show');
    Route::post('addMovieCrew', 'Api\MoviesController@addMovieToCrew');
    Route::post('getCrewMovies', 'Api\MoviesController@showCrewMovies');

    //Este Grupo Necesita Token (usa el middleware jwt-auth)
    Route::group(['middleware' => 'jwt-auth'], function () {
    	Route::post('get_user_details', 'Api\Auth\AuthController@get_user_details');
        
    });
});