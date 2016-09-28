<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Movie extends Model
{
    //
    protected $table = 'movies';
    protected $primaryKey = 'idIMDB';

    protected $fillable = [
        'idIMDB',
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
        'metascore',
        'byUser'
    ];
    
}
