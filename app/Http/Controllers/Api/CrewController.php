<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Crew;
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
            'crewid',
            'name'
            );
        
        $validator = Validator::make($input, [
            'crewid' => 'required|unique:crews,crewid',
            'name' => 'required'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $crew = new Crew;

        $crew->crewid = $request->crewid;
        $crew->name = $request->name;

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
            'crewid'
        );

        $validator = Validator::make($input, [
            'crewid' => 'required'
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
            ['crewid' => $crew->crewid],
            ['name' => $crew->name]
            );
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
        //
    }
}
