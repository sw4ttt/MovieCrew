<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Movie extends Model
{
    //
    protected $table = 'movies';
    protected $primaryKey = 'id';

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
        'byUser',
        'crew_id'
    ];

    public function crews()
    {
        return $this->belongsToMany('App\Crew','crew_movie')->withTimestamps();
    }
    
}
