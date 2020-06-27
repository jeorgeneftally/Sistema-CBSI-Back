<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaterialMenor extends Model
{
    protected $table='materialmenors';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','descripcion','compania_id'
    ];

    //RELACION DE UNO A MUCHOS INVERSA MATERIALMENOR-COMPAÑIA
    public function compañia(){
        return $this->belongsTo('App\Compania','compania_id');
    }

    //relacion uno a muchos de material-detalle
    public function detallebod(){
        return $this->hasMany('App\DetalleBod');
    }

    //relacion uno a muchos de material-detalle
    public function detallebom(){
        return $this->hasMany('App\DetalleBom');
    }
    //relacion uno a muchos de material-detalle
    public function detallemat(){
        return $this->hasMany('App\DetalleMat');
    }

   
}
