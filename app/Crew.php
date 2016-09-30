<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    //

    protected $table = 'crews';
    protected $primaryKey = 'crewid';


    protected $fillable = [
        'crewid',
        'name'
    ];

    public function movies()
    {
        return $this->hasMany('App\Movie','IMDBid');
    }
}
