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

use Psr\Http\Message\ResponseInterface;

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

        /*
        $validator = Validator::make($input, [
            'IMDBid' => 'required|exists:movies,IMDBid'
        ]);
        */

        $validator = Validator::make($input, [
            'IMDBid' => 'required'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        /*

        $movie = (new MoviesController)->getMovie($request->IMDBid);

        if ($movie)
        {
            return response()->json($movie);
        }

        $movie = (new MoviesController)->getMovieFromAPI($request->IMDBid);

        return response()->json($movie);

        */

        $client = new GuzzleHttpClient();
        $promise = $client->requestAsync('GET', 'http://api.myapifilms.com/imdb/idIMDB?idIMDB='.$request->IMDBid.'&token=d76a94d4-dccc-4e2d-a488-26cac8c258ba&simplePlot=1');
        $promise->then(
            function (ResponseInterface $res) 
            {
                //echo $res->getStatusCode() . "\n";
                if ($res->getStatusCode() != 200)
                {
                    return response()->json(['error' => 'Error on Api, status code not 200. (myapifilms)']);
                }

                $content = json_decode($apiRequest->getBody()->getContents());

                return response()->json($content);

            },
            function (RequestException $e) {
                //echo $e->getMessage() . "\n";
                //echo $e->getRequest()->getMethod();

                return response()->json($e->getMessage());
            }
        );
    }

    public function getMovie($IMDBid)
    {
        $movie = Movie::where('IMDBid', $IMDBid)->first();

        if (!$movie)
            return null;

        return $movie;
    }

    public function getMovieFromAPI($imdbid)
    {
               
        try
        { 
            $client = new GuzzleHttpClient();

            $apiRequest = $client->request('GET', 'http://api.myapifilms.com/imdb/idIMDB?idIMDB='.$imdbid.'&token=d76a94d4-dccc-4e2d-a488-26cac8c258ba&simplePlot=1');
            
            if ($apiRequest->getStatusCode() != 200)
            {
                return response()->json(['error' => 'Error on Api, status code not 200. (myapifilms)']);
            }

            $content = json_decode($apiRequest->getBody()->getContents());

            if (array_has($content, 'error'))
            {
                return response()->json(['error' => $content->error->message]);
            }

            $movieAPI = $content->data->movies[0];

            // Check if it is the correct movie.
            if ($movieAPI->idIMDB == $imdbid)
            {
                // It is.
                $movie = new Movie;

                $movie->IMDBid = $movieAPI->idIMDB;
                $movie->title = $movieAPI->title;
                $movie->year = $movieAPI->year;
                $movie->urlIMDB = $movieAPI->urlIMDB;
                $movie->ratingMC = 0; //It gets set based on votes. (thumbs up o something.)
                
                if(array_has($movieAPI, 'runtime'))
                {
                    $movie->runtime = $movieAPI->runtime;
                }
                else
                {
                    $movie->runtime = 'N/A';
                }

                if(array_has($movieAPI, 'urlPoster'))
                {
                    $movie->urlPoster = $movieAPI->urlPoster;
                }
                else
                {
                    $movie->urlPoster = 'N/A';
                }

                if(array_has($movieAPI, 'simplePlot'))
                {
                    $movie->plot = $movieAPI->simplePlot;
                }
                else
                {
                    $movie->plot = 'N/A';
                }

                if(array_has($movieAPI, 'rating'))
                {
                    $movie->ratingIMDB = $movieAPI->rating;
                }
                else
                {
                    $movie->ratingIMDB = 'N/A';
                }

                if(array_has($movieAPI, 'rated'))
                {
                    $movie->rated = $movieAPI->rated;
                }
                else
                {
                    $movie->rated = 'N/A';
                }

                if(array_has($movieAPI, 'votes'))
                {
                    $movie->votes = $movieAPI->votes;
                }
                else
                {
                    $movie->votes = 'N/A';
                }

                if(array_has($movieAPI, 'metascore'))
                {
                    $movie->metascore = $movieAPI->metascore;
                }
                else
                {
                    $movie->metascore = 'N/A';
                }
                $movie->save();

                return response()->json($movie);
            }

            return response()->json(['error' => 'Wrong movie returned on API call.']); 
        }
        catch (RequestException $re) 
        {

            return response()->json(['error' => 'RequestException on API call.']);

        }
    }
}
