<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleMat extends Model
{
    protected $table='detallesmats';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'talla','estado','materialmayor_id','materialmenor_id'
    ];


    //RELACION DE UNO A MUCHOS INVERSA DETALLEMAT-MATERIALMAYOR
    public function materialmayor(){
        return $this->belongsTo('App\MaterialMayor','materialmayor_id');
    }

    //RELACION DE UNO A MUCHOS INVERSA DETALLEMAT-MATERIALMENOR
    public function materialmenor(){
        return $this->belongsTo('App\MaterialMenor','MaterialMenor_id');
    }
    

}
