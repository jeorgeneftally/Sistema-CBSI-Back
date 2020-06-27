<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    protected $table='bodegas';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','descripcion','compania_id'
    ];

    //RELACION DE UNO A MUCHOS INVERSA BODEGA-COMPAÑIA
    public function compañia(){
        return $this->belongsTo('App\Compania','compania_id');
    }
    //relacion uno a muchos de BODEGA-DETALLE
    public function detallebodega(){
        return $this->hasMany('App\DetalleBod');
    }
    
}
