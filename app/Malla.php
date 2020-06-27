<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Malla extends Model
{
    protected $table='mallas';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];

    //relacion uno a muchos de malla-user
    public function user(){
        return $this->hasMany('App\User');
    }

}
