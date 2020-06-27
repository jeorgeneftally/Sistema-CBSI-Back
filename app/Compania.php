<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compania extends Model
{
    protected $table='compañias';
    
    protected $fillable = [
        'nombre','descripcion','lema','fecha_fundacion','imagen_logo'
    ];

   //relacion uno a muchos de compañia-user
   public function user(){
    return $this->hasMany('App\User');
    }

    //relacion uno a muchos de BODEGA-compañia
    public function bodega(){
    return $this->hasMany('App\Bodega');
    }

    //relacion uno a muchos de compañia-materialmenor
    public function materialmenor(){
    return $this->hasMany('App\MaterialMenor');
    }

    //relacion uno a muchos de compañia-materialmayor
    public function materialmayor(){
        return $this->hasMany('App\MaterialMayor');
        }
    

}
