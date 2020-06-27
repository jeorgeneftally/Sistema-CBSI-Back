<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Compania;

class CompañiaController extends Controller
{
    public function index(){
        $companias=Compania::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'companias'=>$companias
        ],200);
    }

    public function show($id){
        $compania=Compania::find($id);

        if(is_object($compania)){
            $data=[
                'code'=>200,
                'status'=>'success',
                'compania'=>$compania
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La compania no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }
 

    /**
     * store guarda un nuevo equipo en la base de datos 
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
                    'message'=> 'No se ha guardado el equipo.'
                ];
            }else{
                //en caso de no haber errores, guarda el modelo en la base de datos
                $compania=new Compania();
                $compania->nombre= $params_array['nombre'];
                $compania->descripcion= $params_array['descripcion'];
                $compania->lema= $params_array['lema'];
                $compania->fecha_fundacion=$params_array['fecha_fundacion'];
                $compania->save();

                $data=[
                    'code'=>200,
                    'status'=>'success',
                    'compania'=> $compania
                ];
            }
        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna compania.'
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
            $compania=Compania::where('id',$id)->update($params_array);

            $data=[
                'code'=>200,
                'status'=>'success',
                'compania'=>$params_array
            ];

        }else{
            $data=[
                'code'=>400,
                'status'=>'error',
                'message'=> 'No has enviado ninguna compania.'
            ];
        }
        return response()->json($data,$data['code']);
    }


    public function destroy($id,Request $request){
        //conseguir el registro 
        $compania=Compania::where('id',$id)->first();
        if(!empty($compania)){
            //Borrar el registro
            $compania->delete();
            //Devolver una respuesta
            $data=[
                'code'=>200,
                'status'=>'success',
                'compania'=>$compania
            ];
        }else{
            $data=[
                'code'=>404,
                'status'=>'error',
                'message'=>'La companiav no existe'
            ];
        }
        return response()->json($data,$data['code']);
    }


    /**
     * upload permite guardar una imagen en el servidor
     */
    public function upload(Request $request){

        //Recoger datos de la petición
        $image=$request->file('file0');

        //validación de la imagen
        $validate=\Validator::make($request->all(),[
            'file0'=>'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        //Guardar imagen
        if(!$image || $validate->fails()){

            $data=array(
                'code'=>400,
                'status'=>'error',
                'message'=>'Error al subir imagen'
            );
            
        }else{

            //asignar nombre a la imagen
            $image_name=time().$image->getClientOriginalName();
            //asignar lugar donde se guardara la imagen en este caso en storage\app\users, se debe configurar 
            //carpeta users en filesystems.php en config, para que pueda guardar las imagenes
            \Storage::disk('companias')->put($image_name,\File::get($image));
        
            $data=array(
                'code'=>200,
                'status'=>'success',
                'image'=>$image_name,
            );
        }

        return response()->json($data,$data['code']);
    }

    /**
     * getImage retorna la imagen del servidor, obtiendo el nombre del archivo y luego
     * buscandola en la carpeta de almacenamiento
     */
    public function getImage($filename){
        //verificar si existe el archivo
        $isset=\Storage::disk('companias')->exists($filename);  
        if($isset){
            $file=\Storage::disk('companias')->get($filename);
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
