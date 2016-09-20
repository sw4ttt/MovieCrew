<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use Validator;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Movie::all();
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
        $input = $request->only('imdbid','title','imdbrating');
        
        $validator = Validator::make($input, [
            'imdbid' => 'required|unique:movies,imdbid',
            'title' => 'required',
            'imdbrating' => 'required',
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $movie = new Movie;

        $movie->imdbid = $request->imdbid;
        $movie->title = $request->title;
        $movie->imdbrating = $request->imdbrating;

        $movie->save();

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
        //
    }
}
