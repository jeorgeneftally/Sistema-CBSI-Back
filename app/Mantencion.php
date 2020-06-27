<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mantencion extends Model
{
    protected $table='mantenciones';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion','taller','nombre_mecanico','fecha','kilometraje','materialmayor_id','user_id'
    ];


    //RELACION DE UNO A MUCHOS INVERSA MANTENCIONES-MATERIALMAYOR
    public function materialmayor(){
        return $this->belongsTo('App\MaterialMayor','materialmayor_id');
    }

    //RELACION DE UNO A MUCHOS INVERSA MANTENCIONES-USER
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

}
