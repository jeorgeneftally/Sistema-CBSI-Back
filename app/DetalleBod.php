<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleBod extends Model
{
    protected $table='detallesbods';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'talla','estado','bodega_id','materialmenor_id'
    ];


    //RELACION DE UNO A MUCHOS INVERSA DETALLEBOD-MATERIALMENOR
    public function materialmenor(){
        return $this->belongsTo('App\MaterialMenor','materialmenor_id');
    }

    //RELACION DE UNO A MUCHOS INVERSA DETALLEBOD-BODEGA
    public function bodega(){
        return $this->belongsTo('App\Bodega','bodega_id');
    }

}
