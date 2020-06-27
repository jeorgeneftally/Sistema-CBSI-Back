<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Rol;


class RolController extends Controller
{
    public function index(){
        $roles=Rol::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'roles'=>$roles
        ],200);
    }

  
}
