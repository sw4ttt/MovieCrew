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
        $movies = Movie::all();
        if ($movies->count() == 0)
        {
            return response()->json(['result'=>'empty']);
        }
        return $movies;
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
            'IMDBid',
            'title',
            'year',
            'runtime',
            'urlPoster',
            'urlIMDB',
            'plot',
            'ratingIMDB',
            'ratingMC',
            'rated',
            'votes',
            'metascore'
            );
        
        $validator = Validator::make($input, [
            'IMDBid' => 'required|unique:movies,IMDBid',
            'title' => 'required',
            'year' => 'required',
            'runtime' => 'required',
            'urlPoster' => 'required',
            'urlIMDB' => 'required',
            'plot' => 'required',
            'ratingIMDB' => 'required',
            'ratingMC' => 'required',
            'rated' => 'required',
            'votes' => 'required',
            'metascore' => 'required'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $movie = new Movie;

        $movie->IMDBid = $request->IMDBid;
        $movie->title = $request->title;
        $movie->year = $request->year;
        $movie->runtime = $request->runtime;
        $movie->urlPoster = $request->urlPoster;
        $movie->urlIMDB = $request->urlIMDB;
        $movie->plot = $request->plot;
        $movie->ratingIMDB = $request->ratingIMDB;
        $movie->ratingMC = $request->ratingMC;
        $movie->rated = $request->rated;
        $movie->votes = $request->votes;
        $movie->metascore = $request->metascore;

        $movie->save();

        return response()->json(['result'=>'true']);
    }

    public function addMovieToCrew(Request $request)
    {
        //
        $input = $request->only(
            'movie_id',
            'crew_id'
            );
        
        $validator = Validator::make($input, [
            'crew_id' => 'required|exists:crews,id',
            'movie_id' => 'required|exists:movies,id'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $crew = Crew::find($request->crew_id);

        $crew->movies()->attach($request->movie_id);

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
            'IMDBid'
        );

        $validator = Validator::make($input, [
            'IMDBid' => 'required'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $movie = Movie::find($request->IMDBid);

        if (is_null($movie))
        {
            return response()->json(['result' => 'empty']);
        }
        
        return response()->json(
            ['result' => true],
            ['IMDBid' => $movie->IMDBid],
            ['title' => $movie->title],
            ['year' => $movie->year],
            ['runtime' => $movie->runtime],
            ['urlPoster' => $movie->urlPoster],
            ['urlIMDB' => $movie->urlIMDB],
            ['plot' => $movie->plot],
            ['ratingIMDB' => $movie->ratingIMDB],
            ['ratingMC' => $movie->ratingMC],
            ['rated' => $movie->rated],
            ['votes' => $movie->votes],
            ['metascore' => $movie->metascore]
            );
    }
}
