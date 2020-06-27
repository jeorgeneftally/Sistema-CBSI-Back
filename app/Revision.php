<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Revision extends Model
{
    protected $table='revisiones';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion','ubicacion','nombre','fecha','proxima_fecha','kilometraje','materialmayor_id','user_id'
    ];


    //RELACION DE UNO A MUCHOS INVERSA REVISIONES-MATERIALMAYOR
    public function materialmayor(){
        return $this->belongsTo('App\MaterialMayor','materialmayor_id');
    }

    //RELACION DE UNO A MUCHOS INVERSA REVISIONES-USER
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
   
}
