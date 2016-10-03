<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Crew;
use App\User;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        if ($users->count() == 0)
        {
            return response()->json(['result'=>'empty']);
        }
        return $users;
    }

    public function delete (Request $request)
    {
        $input = $request->only(
            'id'
        );

        $validator = Validator::make($input, [
            'id' => 'required'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $user = User::find($request->id);

        if (!$user)
        {
            return response()->json(['result'=>'user with given id not found.']);    
        }

        $user->delete();   

        return response()->json(['result'=>'true']);    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function addCrewToUser(Request $request)
    {
        $input = $request->only(
            'user_id',
            'crew_id'
        );

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'crew_id' => 'required'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);

        if (!$user)
        {
            return response()->json(['result'=>'user with given id not found.']);    
        }

        $crew = Crew::find($request->crew_id);

        if (!$crew)
        {
            return response()->json(['result'=>'crew with given id not found.']);    
        }

        $user->crews()->attach($request->crew_id);   

        return response()->json(['result'=>'true']);  

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = $request->only(
            'id'
        );

        $validator = Validator::make($input, [
            'id' => 'required'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }
        
        App\User::destroy($request->id);
    }

}
