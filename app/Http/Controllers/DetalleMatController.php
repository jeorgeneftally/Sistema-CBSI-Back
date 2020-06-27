<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DetalleMat;

class DetalleMatController extends Controller
{
    public function index(){
        $detalles=DetalleMat::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'detalles'=>$detalles
        ],200);
    }


    public function show($id){
        $detalle=DetalleMat::find($id);

        if(is_object($detalle)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'detalle'=>$detalle
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'Los detalles no existe'
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
                'talla'=>'required',
                
            ]);
            //guardar el modelo
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado la serie.'
                ];
            }else{
                //en caso de no haber errores, guarda el modelo en la base de datos
                $detalles=new DetalleMat();
                $detalles->talla= $params_array['talla'];
                $detalles->estado= $params_array['estado'];
                $detalles->materialmenor_id= $params_array['materialmenor_id'];
                $detalles->materialmayor_id= $params_array['materialmayor_id'];
                $detalles->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'detalles'=> $detalles
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun detalle'
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
            $detalles=DetalleMat::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'detalles'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun detalles.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function destroy($id,Request $request){
        //conseguir el registro 
        $detalles=DetalleMat::where('id',$id)->first();
        if(!empty($detalles)){

            //Borrar el registro
            $detalles->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'detalles'=>$detalles
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El detalle no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
    
}
