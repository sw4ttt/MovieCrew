<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Crew;
use App\User;
use Validator;

use App\Http\Requests;

class CrewController extends Controller
{
    public function index()
    {
        //
        $crews = Crew::all();
        if ($crews->count() == 0)
        {
            return response()->json(['result'=>'empty']);
        }
        return $crews;
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
        $input = $request->only(
            'name',
            'user_id'
            );
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $crew = new Crew;

        $crew->name = $request->name;
        $crew->user_id = $request->user_id;

        $crew->save();

        return response()->json(['result'=>'true']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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

        $crew = Crew::find($request->crew);

        if (is_null($crew))
        {
            return response()->json(['result' => 'empty']);
        }
        
        return response()->json(
            ['result' => true],
            ['id' => $crew->id],
            ['name' => $crew->name]
            );
    }

    public function showCrewUser(Request $request)
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
        
        $crew = Crew::find($request->id);

        if (is_null($crew))
        {
            return response()->json(['result' => 'empty']);
        }

        //return $crew->user->email;
        return $crew->user->toJson();
    }

    public function showUserCrews(Request $request)
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

        if (is_null($user))
        {
            return response()->json(['result' => 'empty']);
        }

        //return $crew->user->email;
        return $user->crews->toJson();
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

        $crew = Crew::find($request->id);

        if (!$crew)
        {
            return response()->json(['result'=>'crew with given id not found.']);    
        }

        $crew->delete();   

        return response()->json(['result'=>'true']);    
    }
}
