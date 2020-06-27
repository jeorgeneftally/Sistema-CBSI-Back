<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleBom extends Model
{
    protected $table='detallesbs';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'talla','estado','user_id','materialmenor_id'
    ];


    //RELACION DE UNO A MUCHOS INVERSA DETALLEBOM-USER
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    //RELACION DE UNO A MUCHOS INVERSA DETALLEBOM-MATERIALMENOR
    public function materialmenor(){
        return $this->belongsTo('App\MaterialMenor','MaterialMenor_id');
    }

}
