<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //
    protected $table = 'movies';
    protected $primaryKey = 'imdbid';

    protected $fillable = [
        'imdbid', 
        'title',
        'imdbrating',
    ];
    
}
