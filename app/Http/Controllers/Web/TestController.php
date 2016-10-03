<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class TestController extends Controller
{
    //

    public function index()
    {
        try
        { 
            $client = new GuzzleHttpClient();

            $apiRequest = $client->request('GET', 'http://api.myapifilms.com/imdb/idIMDB?title=matrix&token=d76a94d4-dccc-4e2d-a488-26cac8c258ba');

            // echo $apiRequest->getStatusCode());
            // echo $apiRequest->getHeader('content-type'));

            //echo $apiRequest->getStatusCode();

            if ($apiRequest->getStatusCode() != 200)
            {
                return response()->json(['error' => 'Error Api myapifilms not 200']);
            }

            $content = json_decode($apiRequest->getBody()->getContents());

            //var_dump($content->data->movies[0]->title);
            return $content->data->movies[0]->title;

            //return response()->json(['error' => 'Error Api myapifilms not 200']);

            //return dd($content);

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
            //For handling exception
        }

    }
}
