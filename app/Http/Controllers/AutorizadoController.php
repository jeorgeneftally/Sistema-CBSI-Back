<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Autorizado;

class AutorizadoController extends Controller
{
    public function index(){
        $autorizados=Autorizado::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'autorizados'=>$autorizados
        ],200);
    }

    public function show($id){
        $autorizado=Autorizado::find($id);

        if(is_object($autorizado)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'autorizado'=>$autorizado
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El autorizado no existe'
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
                'fecha'=>'required',  
            ]);
            //guardar el modelo
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el autorizado.'
                ];
            }else{
                //en caso de no haber errores, guarda el modelo en la base de datos
                $autorizado=new Autorizado();
                $autorizado->fecha= $params_array['fecha'];
                $autorizado->materialmayor_id= $params_array['materialmayor_id'];
                $autorizado->user_id= $params_array['user_id'];
                $autorizado->conductor_id= $params_array['conductor_id'];
                $autorizado->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'autorizado'=> $autorizado
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun autorizado'
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
                'fecha'=>'required',
            ]);

            //quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $autorizado=Autorizadi::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'autorizado'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun autorizado.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function destroy($id,Request $request){
        //conseguir el registro 
        $autorizado=Autorizado::where('id',$id)->first();
        if(!empty($autorizado)){

            //Borrar el registro
            $autorizado->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'autorizado'=>$autorizado
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El autorizado no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
    
}
