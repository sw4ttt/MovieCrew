<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use GuzzleHttp\Client;

class TestController extends Controller
{
    //

    public function index()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://www.omdbapi.com/?t=matrix&y=&plot=short&r=json');
        //var_dump($res);
        return  $res->getBody();
    }
}
