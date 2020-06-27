<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\MaterialMayor;

class MaterialMayorController extends Controller
{
    public function index(){
        $materialmayor=MaterialMayor::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'materialmayor'=>$materialmayor
        ],200);
    }


    public function show($id){
        $materialmayor=MaterialMayor::where('compania_id',$id)->get();
        if(is_object($materialmayor)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'materialmayor'=>$materialmayor
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La materialmayor no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
    public function show2($id){
        $materialmayor=MaterialMayor::find($id);
        if(is_object($materialmayor)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'materialmayor'=>$materialmayor
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La materialmayor no existe'
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
                    'message'=> 'No se ha guardado el material mayor.'
                ];
            }else{
                //en caso de no haber errores, guarda el modelo en la base de datos
                $materialmayor=new MaterialMayor();
                $materialmayor->nombre= $params_array['nombre'];
                $materialmayor->descripcion= $params_array['descripcion'];
                $materialmayor->fecha_creacion= $params_array['fecha_creacion'];
                $materialmayor->capacidad= $params_array['capacidad'];
                $materialmayor->chasis= $params_array['chasis'];
                $materialmayor->motor= $params_array['motor'];
                $materialmayor->patente= $params_array['patente'];
                $materialmayor->marca= $params_array['marca'];
                $materialmayor->modelo= $params_array['modelo'];
                $materialmayor->estado= $params_array['estado'];
                $materialmayor->compania_id= $params_array['compania_id'];
                $materialmayor->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'materialmayor'=> $materialmayor
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun material mayor'
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
            $materialmayor=MaterialMayor::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'materialmayor'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ningun materialmayor.'
            ];
        }
        return response()->json($data,$data['code']);
    }

    public function destroy($id,Request $request){
        //conseguir el registro 
        $materialmayor=MaterialMayor::where('id',$id)->first();
        if(!empty($materialmayor)){

            //Borrar el registro
            $materialmayor->delete();
            
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'materialmayor'=>$materialmayor
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La materialmayor no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
    

      /**
     * upload permite guardar una nueva imagen en la base de datos
     */
    public function upload(Request $request){

        //Recoger datos de la petición
        $imagen=$request->file('file0');

        //validación de la imagen
        $validate=\Validator::make($request->all(),[
            'file0'=>'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        //Guardar imagen
        if(!$imagen || $validate->fails()){

            $data=array(
                'code'=>400,
                'status'=>'error',
                'message'=>'Error al subir imagen'
            );
            
        }else{

            //asignar nombre a la imagen
            $image_name=time().$imagen->getClientOriginalName();
            //guarda la imagen en el servidor, especificando la carpeta en este caso storage\app\products,
            //la carpeta products se debe configurar en filesystems.php para permitir que almacene archivos
            \Storage::disk('carros')->put($image_name,\File::get($imagen)); 
        
            $data=array(
                'code'=>200,
                'status'=>'success',
                'image'=>$image_name,
            );

        }

        return response()->json($data,$data['code']);
    }

    /**
     * getImage retorna la imagen almacenada en el servidor para ello debe recibir el nombre de la imagen
     * y buscarla en la carpeta especificada
     */
    public function getImage($filename){
        //verificar si existe el archivo
        $isset=\Storage::disk('carros')->exists($filename);  
        if($isset){
            $file=\Storage::disk('carros')->get($filename);
            return new Response($file,200);
        }else{
            $data=array(
                'code'=>404,
                'status'=>'error',
                'message'=>'La imagen no existe',
            );

            return response()->json($data,$data['code']);
        }
    }
}