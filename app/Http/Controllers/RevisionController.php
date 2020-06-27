<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Revision;


class RevisionController extends Controller
{
    public function index(){
        $revisiones=Revision::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'revisiones'=>$revisiones
        ],200);
    }

    public function show($id){
        $revision=Revision::find($id);

        if(is_object($revision)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'revision'=>$revision
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'la revision no existe'
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
                'fecha' => 'required'
            ]);

            //guardar el campeonato
            if($validate->fails()){
                $data=[
                    'code'=>400,
                    'status'=>'error',
                    'message'=> 'No se ha guardado la revision.'
                ];
            }else{
                //en caso de no haber errores, guarda el estudiante en la base de datos
                $revision=new Revision();
                $revision->nombre=$params_array['nombre'];
                $revision->descripcion=$params_array['descripcion'];
                $revision->ubicacion=$params_array['ubicacions'];
                $revision->fecha=$params_array['fecha'];
                $revision->proxima_fecha=$params_array['proxima_fecha'];
                $revision->kilometraje=$params_array['kilomentraje'];
                $revision->materialmayor_id=$params_array['materialmayor_id'];
                $revision->user_id=$params_array['user_id'];
                $revision->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'revision'=> $revision
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna revision.'
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
            $revision=Revision::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'revision'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna revision.'
            ];
        }
        return response()->json($data,$data['code']);
    }
    

    public function destroy($id,Request $request){
        //conseguir el registro 
        $revision=Revision::where('id',$id)->first();
        if(!empty($revision)){

            //Borrar el registro
            $revision->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'revision'=>$revision
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'la revision no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
}
