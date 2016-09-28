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
        /*
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://www.omdbapi.com/?t=the+matrix&y=&plot=short&r=json');
        //var_dump($res);
        //return  $res->getBody();
        $elements = (string)$res->getBody();

        //$resArray = (array)$elements[0];

        

        //var_dump($elements[0]) ;

        return $elements.'Title';

        */


        try {
 
           $client = new GuzzleHttpClient();
 
           $apiRequest = $client->request('GET', 'http://api.myapifilms.com/imdb/idIMDB?title=matrix&token=d76a94d4-dccc-4e2d-a488-26cac8c258ba');
 
          // echo $apiRequest->getStatusCode());
          // echo $apiRequest->getHeader('content-type'));
 
          $content = json_decode($apiRequest->getBody()->getContents());

          var_dump($content);
          return $content->Title;
 
      } catch (RequestException $re) {
          //For handling exception
      }

    }
}
