<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DetalleBom;

class DetalleBomController extends Controller
{
    public function index(){
        $detalleBoms=DetalleBom::all();

        return response()->json([
            'code'=>200,
            'status'=>'success',
            'detalleBoms'=>$detalleBoms
        ],200);
    }

    public function show($id){
        $detalleBom=DetalleBom::find($id);

        if(is_object($detalleBom)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'detalleBom'=>$detalleBom
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El DetalleBom no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

     
    /**
     * store guarda un nuevo estudiante en la base de datos 
     */
    public function store(Request $request){
        
        //Recoger los datos por post
        $json=$request->input('json',null);
        $params_array=json_decode($json,true);

        if(!empty($params_array)){
            //validar los datos
            $validate=\Validator::make($params_array,[
                'talla'=>'required',
                    
            ]);

            //guardar el estudiante
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el DetalleBom.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $detalleBom=new DetalleBom();
                $detalleBom->talla= $params_array['talla'];
                $detalleBom->estado=$params_array['estado'];
                $detalleBom->materialmenor_id=$params_array['materialmenor_id'];
                $detalleBom->user_id=$params_array['user_id'];
                $detalleBom->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'detalleBom'=> $detalleBom
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun detallebom.'
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
                'talla'=>'required',
            ]);

            //quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $detalleBom=DetalleBom::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'detalleBom'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun detallebom.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function destroy($id,Request $request){
        //conseguir el registro 
        $detalleBom=DetalleBom::where('id',$id)->first();
        if(!empty($detalleBom)){

            //Borrar el registro
            $detalleBom->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'detalleBom'=>$detalleBom
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El detalleBom no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

   

}
