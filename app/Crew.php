<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    //

    protected $table = 'crews';
    protected $primaryKey = 'id';


    protected $fillable = [
        'name',
        'user_id'
    ];

    public function movies()
    {
        return $this->hasMany('App\Movie','IMDBid');
    }
}
