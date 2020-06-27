<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizado extends Model
{
    protected $table='autorizados';
    
    protected $fillable = [
        'fecha','materialmayor_id','user_id','conductor_id'
    ];

    
    //RELACION DE UNO A MUCHOS INVERSA AUTORIZADOS-MATERIALMAYOR
    public function materialmayor(){
        return $this->belongsTo('App\MaterialMayor','materialmayor_id');
    }
    //RELACION DE UNO A MUCHOS INVERSA AUTORIZADOS-USER
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
    //RELACION DE UNO A MUCHOS INVERSA AUTORIZADOS-CONDUCTOR
    public function conductor(){
        return $this->belongsTo('App\Conductor','conductor_id');
    }
}
