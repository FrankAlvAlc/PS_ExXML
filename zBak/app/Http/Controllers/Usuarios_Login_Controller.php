<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuarios;
use SoapClient;
use Cookie;



class Usuarios_Login_Controller extends Controller
{
    public function index(){
      return view('login');
    }

/*==================================================*/
 public function LogOut(){
   Cookie::queue(Cookie::forget('Usuario_ID'));
   return redirect('/');
 }
/*==================================================*/
    public function Login(Request $r){

      $client = new SoapClient("http://10.10.3.5:8081/WSGrupoSanchez.asmx?wsdl");
      $array_respuesta = $client->Login(["Usuario"=>$r->input('txtUsuario'),"Password"=>$r->input('txtPwd')]);
      $Respuesta = json_decode($array_respuesta->LoginResult);
      require_once('C-Funciones.php');

      switch($Respuesta->CODIGO){
        case "404":
          return view('Login')->with("UName",$r->input('txtUsuario'));
        break;
        case "022":
         // Usuario inactivo (Ya no labora en la empresa)
             return view('Login')->with("UName",$r->input('txtUsuario'));
        break;
        case "200":
        //Usuario Activo, puede iniciar sesión
          return redirect('/Menu')->with(compact('Usuario'))
                                   ->cookie("Nombre",ucwords(strtolower(TruncarString($Respuesta->COLABORADOR,24))))
                                   ->cookie("Usuario_ID",$Respuesta->COLABORADOR_ID)
                                   ->cookie("Departamento_ID",$Respuesta->DEPARTAMENTO_ID)
                                   ->cookie("Nom_Depto",$Respuesta->NOMBRE_DPTO)
                                   ->cookie("Cve_Depto",$Respuesta->CLAVE_CENTRO)
                                   ->cookie("Log_Super",$Respuesta->ES_SUPER);

        break;

      }
    }

}
