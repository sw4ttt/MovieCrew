<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Movie extends Model
{
    //
    protected $table = 'movies';
    protected $primaryKey = 'IMDBid';

    protected $fillable = [
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
        'metascore',
        'byUser'
    ];

    public function crew()
    {
        return $this->belongsTo('App\Crew','crewid');
    }
    
}
