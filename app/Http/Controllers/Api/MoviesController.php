<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Crew;
use App\User;
use Validator;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

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
        $movie = Movie::find($request->movie_id);

        foreach ($crew->movies as $movieOfCrew) 
        {
            if($movieOfCrew->id == $movie->id)
            {
                return response()->json(['result'=>'false']);
            }
        }

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
            'IMDBid' => 'required|exists:movies,IMDBid'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        return this.searchMovieAPI($input->IMDBid);
        

        //$movie = Movie::find($request->IMDBid);
        /*
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
        */
    }

    public function searchMovieDB(Request $request)
    {

        $input = $request->only(
            'IMDBid'
        );

        $validator = Validator::make($input, [
            'IMDBid' => 'required|exists:movies,IMDBid'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $movie = Movie::where('IMDBid', $request->IMDBid)->first();

        return $movie;
    }

    public function searchMovieAPI($imdbid)
    {
        
        try
        { 
            $client = new GuzzleHttpClient();

            $apiRequest = $client->request('GET', 'http://api.myapifilms.com/imdb/idIMDB?title=matrix&token=d76a94d4-dccc-4e2d-a488-26cac8c258ba');
            
            if ($apiRequest->getStatusCode() != 200)
            {
                return response()->json(['error' => 'Error Api myapifilms.']);
            }

            $content = json_decode($apiRequest->getBody()->getContents());

            $movieAPI = movies[0];

            // Check if it is the correct movie.
            if ($movieAPI->idIMDB == $imdbid)
            {
                // It is. 

                $movie = new Movie;

                $movie->IMDBid = $movieAPI->idIMDB;
                $movie->title = $movieAPI->title;
                $movie->year = $movieAPI->year;
                $movie->runtime = $movieAPI->runtime;
                $movie->urlPoster = $movieAPI->urlPoster;
                $movie->urlIMDB = $movieAPI->urlIMDB;
                $movie->plot = $movieAPI->plot;
                $movie->ratingIMDB = $movieAPI->rating;
                $movie->ratingMC = 0;
                $movie->rated = $movieAPI->rated;
                $movie->votes = $movieAPI->votes;
                $movie->metascore = $movieAPI->metascore;

                //$movie->save();

                return response()->json($movie->toJson());
            }


            return response()->json(['error' => 'Wrong movie returned on API call.']);

            /*
            {[{
                "title":"The Matrix"
                "year":"1999"
                "releaseDate":"19990331"
                "directors":[{"name":"Lana Wachowski","id":"nm0905154"},{"name":"Lilly Wachowski","id":"nm0905152"}]
                "writers":[{"name":"Lilly Wachowski","id":"nm0905152"},{"name":"Lana Wachowski","id":"nm0905154"}]
                "runtime":"136 min"
                "urlPoster":"https://images-na.ssl-images-amazon.com/images/M/MV5BMDMyMmQ5YzgtYWMxOC00OTU0LWIwZjEtZWUwYTY5MjVkZjhhXkEyXkFqcGdeQXVyNDYyMDk5MTU@._V1_UY268_CR6,0,182,268_AL_.jpg"
                "genres":["Action","Sci-Fi"]
                "plot":"Thomas A. Anderson is a man living two lives. By day he is an average computer programmer and by night a hacker known as Neo. Neo has always questioned his reality, but the truth is far beyond his imagination. Neo finds himself targeted by the police when he is contacted by Morpheus, a legendary computer hacker branded a terrorist by the government. Morpheus awakens Neo to the real world, a ravaged wasteland where most of humanity have been captured by a race of machines that live off of the humans' body heat and electrochemical energy and who imprison their minds within an artificial reality known as the Matrix. As a rebel against the machines, Neo must return to the Matrix and confront the agents: super-powerful computer programs devoted to snuffing out Neo and the entire human rebellion.","simplePlot":"A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers."
                "idIMDB":"tt0133093"
                "urlIMDB":"http://www.imdb.com/title/tt0133093"
                "rating":"8.7"
                "metascore":"73"
                "rated":"R"
                "votes":"1,230,474"
                "type":"Movie"
            }]}
            */
 
        }
        catch (RequestException $re) 
        {

            return response()->json(['error' => 'RequestException on API call.']);

        }
    }
}
