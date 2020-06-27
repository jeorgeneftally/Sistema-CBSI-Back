<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Conductor extends Model
{
    protected $table='conductores';
    
    protected $fillable = [
        'habilitado','nomeclatura'
    ];

    
     //relacion uno a muchos de conductor.user
     public function user(){
        return $this->hasMany('App\User');
    }
     //relacion uno a muchos de tabla-campeonato
     public function autorizado(){
        return $this->hasMany('App\Autorizado');
    }
    
}
