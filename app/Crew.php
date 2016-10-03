<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    //

    protected $table = 'crews';
    protected $primaryKey = 'id';


    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User','crew_user')->withTimestamps();
    }
}
