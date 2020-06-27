<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Malla;

class MallaController extends Controller
{
    public function index(){
        $mallas=Malla::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'mallas'=>$mallas
        ],200);
    }


    
}
