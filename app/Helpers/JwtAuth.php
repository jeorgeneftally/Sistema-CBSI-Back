<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

class JwtAuth{

    public $key;

    public function __construct(){
        $this->key='esto_es_una_clave_super_secreta-898998765';
    }

    /**
     * Funcion para el acceso de usuario 
    */
    public function signup($email,$password, $getToken=null){
        //buscar si existe el usuario con sus credenciales
        $user=User::where([
            'email'=>$email,
            'password'=>$password
        ])->first();

        //comprobar si son correctas 
        $signup=false;
        if(is_object($user)){
            $signup=true;
        }

        //Generar el token con los datos del usuario identificado

        if($signup){
            $token=array(
                'sub'=>$user->id,
                'name'=>$user->name,
                'surname'=>$user->surname,
                'email'=>$user->email,
                'profesion'=>$user->profesion,
                'rut'=>$user->rut,
                'image'=>$user->image,
                'fecha_nacimiento'=>$user->fecha_nacimiento,
                'fecha_ingreso'=>$user->fecha_ingreso,
                'direccion'=>$user->direccion,
                'telefono'=>$user->telefono,
                'talla_calzado'=>$user->talla_calzado,
                'talla_ropa'=>$user->talla_ropa,
                'cargo'=>$user->cargo,
                'numero_registro'=>$user->numero_registro,
                'servicio'=>$user->servicio,
                'estado'=>$user->estado,
                'rol_id'=>$user->rol_id,
                'compania_id'=>$user->compania_id,
                'malla_id'=>$user->malla_id,
                'conductor_id'=>$user->conductor_id,
                'iat'=> time(),
                'exp' => time()+(7*24*60*60)  //tiempo en que expira la sesion de inicio
            );
            $jwt=JWT::encode($token,$this->key,'HS256');  //codifica el token (los datos del usuario)
            $decoded= JWT::decode($jwt,$this->key,['HS256']); //decodifica el token y entrega la información del token (datos del usuario)

            //devolver los datos decodificados o el token, en funcion del atributo que se entrega a la funcion (tercer parametro)            
            if(is_null($getToken)){
                $data= $jwt;
            }else{
                $data= $decoded;
            }
        
        }else{
            $data=array(
                'status'=>'error',
                'message'=>'Login incorrecto'
            );
        }

        return $data;

    }
    
    /**
     * funcion para checkear el token de usuario
     */
    public function checkToken($jwt,$getIdentity=false){ //getIdentity es un boolean, en caso de querer recibir los datos del usuario debe ir como true
        $auth=false;

        try{
            //le quitamos los " al token para que no tenga problemas al validarlo
            $jwt=str_replace('"','',$jwt);  
            $decoded=JWT::decode($jwt,$this->key,['HS256']);
        }catch(\UnexpectedValueException $e){
            $auth=false;
        }catch(\DomainException $e){
            $auth=false;
        }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth=true;
        }else{
            $auth=false;
        }

        if($getIdentity){
            return $decoded;
        }

        return $auth;
    }
}

