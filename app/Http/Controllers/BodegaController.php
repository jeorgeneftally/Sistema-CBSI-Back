<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Bodega;


class BodegaController extends Controller
{
    public function index(){
        $bodegas=Bodega::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'bodegas'=>$bodegas
        ],200);
    }

    public function show($id){
        $bodega=Bodega::find($id);

        if(is_object($bodega)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'bodega'=>$bodega
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'el bodega no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

       /**
     * store guarda un nuevo campeonato en la base de datos 
     */
    public function store(Request $request){
        
        //Recoger los datos por post
        $json=$request->input('json',null);
        $params_array=json_decode($json,true);

        if(!empty($params_array)){
            //validar los datos
            $validate=\Validator::make($params_array,[
                'nombre' => 'required',
            ]);

            //guardar el campeonato
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el bodega.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $bodega=new Bodega();
                $bodega->nombre=$params_array['nombre'];
                $bodega->descripcion=$params_array['descripcion'];
                $bodega->compania_id=$params_array['compania_id'];
                $bodega->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'bodega'=> $bodega
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna bodega.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    /**
     * update permite actualizar un modelo en la base de datos
     */
    public function update($id,Request $request){

        //Recoger datos por post
        $json=$request->input('json',null);
        $params_array=json_decode($json,true);

        if(!empty($params_array)){
            //Validar los datos
            $validate=\Validator::make($params_array,[
                'nombre' => 'required'
                
            ]);

            //quitar los datos que no quiero actualizar
            //unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $bodega=Bodega::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'bodega'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna bodega.'
            ];
        }
        return response()->json($data,$data['code']);
    }
    

    public function destroy($id,Request $request){
        //conseguir el registro 
        $bodega=Bodega::where('id',$id)->first();
        if(!empty($bodega)){

            //Borrar el registro
            $bodega->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'bodega'=>$bodega
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El bodega no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

}
