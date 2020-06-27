<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialMayor extends Model
{
    protected $table='materialmayors';
    
    protected $fillable = [
        'nombre','descripcion','fecha_creacion','capacidad','motor','chasis','patente','marca','modelo','estado','imagen','compania_id'
    ];
   
    //RELACION DE UNO A MUCHOS INVERSA MATERIALMAYOR-COMPAÑIA
    public function compañia(){
        return $this->belongsTo('App\Compania','compania_id');
    }
    //relacion uno a muchos de materialmayor-detallemat
    public function detallemat(){
        return $this->hasMany('App\DetalleMat');
    }
    //relacion uno a muchos de materialmayor-autorizado
    public function autorizado(){
        return $this->hasMany('App\Autorizado');
    }
    //relacion uno a muchos de materialmayor-autorizado
    public function revision(){
        return $this->hasMany('App\Revision');
    }
    //relacion uno a muchos de materialmayor-autorizado
    public function mantencion(){
        return $this->hasMany('App\Mantencion');
    }
}
