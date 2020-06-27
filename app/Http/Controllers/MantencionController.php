<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mantencion;


class MantencionController extends Controller
{
    public function index(){
        $mantenciones=Mantencion::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'mantenciones'=>$mantenciones
        ],200);
    }

    public function show($id){
        $mantencion=Mantencion::where('materialmayor_id',$id)->get();;

        if(is_object($mantencion)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'mantencion'=>$mantencion
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'el mantencion no existe'
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
                    'message'=> 'No se ha guardado la mantencion.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $mantencion=new Mantencion();
                $mantencion->taller=$params_array['taller'];
                $mantencion->descripcion=$params_array['descripcion'];
                $mantencion->nombre_mecanico=$params_array['nombre_mecanico'];
                $mantencion->fecha=$params_array['fecha'];
                $mantencion->proxima_fecha=$params_array['proxima_fecha'];
                $mantencion->kilometraje=$params_array['kilometraje'];
                $mantencion->materialmayor_id=$params_array['materialmayor_id'];
                $mantencion->user_id=$params_array['user_id'];
                $mantencion->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'mantencion'=> $mantencion
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna mantencion.'
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
                'fecha' => 'required',
                
            ]);

            //quitar los datos que no quiero actualizar
            //unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $mantencion=Mantencion::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'mantencion'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna mantencion.'
            ];
        }
        return response()->json($data,$data['code']);
    }
    

    public function destroy($id,Request $request){
        //conseguir el registro 
        $mantencion=Mantencion::where('id',$id)->first();
        if(!empty($mantencion)){

            //Borrar el registro
            $mantencion->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'mantencion'=>$mantencion
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La mantencion no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
}
