<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname','email','profesion','rut','image','fecha_nacimiento',
        'fecha_ingreso','direccion','telefono','talla_calzado','talla_ropa',
        'cargo','numero_registro','servicio','estado','rol_id','compania_id','malla_id','conductor_id'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //RELACION DE UNO A MUCHOS INVERSA USER-COMPAÑIA
    public function compania(){
        return $this->belongsTo('App\Compania','compania_id');
    }
    //RELACION DE UNO A MUCHOS INVERSA USER-ROL
    public function rol(){
        return $this->belongsTo('App\Rol','rol_id');
    }
    //RELACION DE UNO A MUCHOS INVERSA USER-CONDUCTOR
    public function conductor(){
        return $this->belongsTo('App\Conductor','conductor_id');
    }
    //RELACION DE UNO A MUCHOS INVERSA USER-MALLA
    public function malla(){
        return $this->belongsTo('App\Malla','malla_id');
    }

    //relacion uno a muchos de user-detallebom
    public function detalleBombero(){
        return $this->hasMany('App\DetalleBom');
    }
}
