<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table='roles';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rol'
    ];

    //relacion uno a muchos de rol-user
    public function user(){
        return $this->hasMany('App\User');
    }
}
