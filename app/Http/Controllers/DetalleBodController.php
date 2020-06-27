<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DetalleBod;

class DetalleBodController extends Controller
{
    public function index(){
        $detalleBods=DetalleBod::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'detalleBods'=>$detalleBods
        ],200);
    }

    public function show($id){
        $detalleBod=DetalleBod::find($id);

        if(is_object($jugador)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'detalleBod'=>$detalleBod
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El detalleBod no existe'
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
                'talla' => 'required',
                'estado' => 'required',

            ]);

            //guardar el detalle
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado el jugador.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $detalleBod=new DetalleBod();
                $detalleBod->talla= $params_array['talla'];
                $detalleBod->estado=$params_array['estado'];
                $detalleBod->bodega_id=$params_array['bodega_id'];
                $detalleBod->materialmenor_id=$params_array['materialmenor_id'];
                $detalleBod->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'detalleBod'=> $detalleBod
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun detalleBod.'
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
                'talla' => 'required',
                'estado' => 'required',
            ]);

            //quitar los datos que no quiero actualizar
           // unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro de modelo
            $detalleBod=DetalleBod::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'detalleBod'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun detalleBod.'
            ];
        }
        return response()->json($data,$data['code']);
    }


    public function destroy($id,Request $request){
        //conseguir el registro 
        $detalleBod=DetalleBod::where('id',$id)->first();
        if(!empty($detalleBod)){

            //Borrar el registro
            $detalleBod->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'detalleBod'=>$detalleBod
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'El detalleBod no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }

     
}
