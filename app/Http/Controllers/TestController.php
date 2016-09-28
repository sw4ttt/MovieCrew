<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

            echo $apiRequest->getStatusCode();

            $content = json_decode($apiRequest->getBody()->getContents());

            //var_dump($content->data->movies[0]->title);
            return $content->data->movies[0]->title;
 
        }
        catch (RequestException $re) 
        {
            //For handling exception
        }

    }
}
