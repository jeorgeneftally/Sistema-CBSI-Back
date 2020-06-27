<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\MaterialMenor;

class MaterialMenorController extends Controller
{
    public function index(){
        $materiales=MaterialMenor::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'materiales'=>$materiales
        ],200);
    }


    public function show($id){
        $material=MaterialMenor::find($id);

        if(is_object($material)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'material'=>$material
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El material no existe'
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
                'nombre'=>'required',
                
            ]);
            //guardar el modelo
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el material.'
                ];
            }else{
                //en caso de no haber errores, guarda el modelo en la base de datos
                $material=new MaterialMenor();
                $material->nombre= $params_array['nombre'];
                $material->descripcion= $params_array['descripcion'];
                $material->compañia_id= $params_array['compañia_id'];
                $material->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'material'=> $material
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun material'
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
                'nombre'=>'required',
            ]);

            //quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $material=MaterialMenor::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'material'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun material.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function destroy($id,Request $request){
        //conseguir el registro 
        $material=MaterialMenor::where('id',$id)->first();
        if(!empty($material)){

            //Borrar el registro
            $material->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'material'=>$material
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El material no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
    

       /*funcion para recibir los productos por cliente recibiendo el id del cliente
public function jugadoresporserie($id,$ids){
    $serie=Serie::first()->jugadores($id,$ids);

    if(is_object($serie)){
        $data=array(
            'code'=>200,
            'status'=>'success',
            'serie'=>$serie
        );
    }else{
        $data=array(
            'code'=>404,
            'status'=>'error',
            'message'=>'No hay serie'
        );
    }
    return response()->json($data,$data['code']);
}*/
}
