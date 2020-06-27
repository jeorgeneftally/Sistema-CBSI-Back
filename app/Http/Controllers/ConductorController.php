<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Conductor;

class ConductorController extends Controller
{
    public function index(){
        $conductores=Conductor::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'conductores'=>$conductores
        ],200);
    }


    public function show($id){
        $conductor=Conductor::find($id);

        if(is_object($conductor)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'conductor'=>$conductor
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El conductor no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }


      /**
     * store guarda una nueva ficha en la base de datos 
     */
    public function store(Request $request){
        
        //Recoger los datos por post
        $json=$request->input('json',null);
        $params_array=json_decode($json,true);

        if(!empty($params_array)){
            //validar los datos
            $validate=\Validator::make($params_array,[
                'habilitado'=>'required',
                
            ]);
            //guardar el modelo
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el conductor.'
                ];
            }else{
                //en caso de no haber errores, guarda el modelo en la base de datos
                $conductor=new Conductor();
                $conductor->habilitado= $params_array['habilitado'];
                $conductor->nomeclatura= $params_array['nomeclatura'];
                $conductor->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'conductor'=> $conductor
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun conductor'
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
                'habilitado'=>'required',
            ]);

            //quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $conductor=Conductor::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'conductor'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun conductor.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function destroy($id,Request $request){
        //conseguir el registro 
        $conductor=Conductor::where('id',$id)->first();
        if(!empty($conductor)){

            //Borrar el registro
            $conductor->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'conductor'=>$conductor
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El conductor no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
    
}
