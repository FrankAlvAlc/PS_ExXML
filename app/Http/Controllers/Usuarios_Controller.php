<?php

namespace App\Http\Controllers;
use SoapClient;

use App\Mail\EnviarCredenciales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Usuarios_Controller extends Controller
{
    public function index(){
      $CMenu = new Menu_Principal_Controller;
      $MenuPrincipal = $CMenu->MenuPrincipal();
      return view('Usuarios-Crear',compact('MenuPrincipal'));

    }

    /*==========================================================*/

    function InfoColaboradores($Filtro){
      $client = new SoapClient("http://10.10.3.5:8081/WSGrupoSanchez.asmx?wsdl");
      $array_respuesta = $client->Buscar_Colaboradores(["Nombre"=>$Filtro]);
      $Respuesta = json_decode($array_respuesta->Buscar_ColaboradoresResult);

      return $Respuesta;
    }

    /*===========================================================*/

    public function CrearNuevo(Request $r){

      $DatosGral = explode('|', $r->input('DatosGral'));
      $Mail = $r->input('Mail');
      $UName = $r->input('UName');
      $Telefono = $r->input('Telefono');
      //Ns+'|'+Rf+'|'+Nombre+'|'+Paterno+'|'+Materno+'|'+Puesto+'|'+Empresa+'|'+Dep;
      require_once('C-Funciones.php');
      $Pwd = randomPassword(10);
      $EnviarDatos = new SoapClient("http://10.10.3.5:8081/WSGrupoSanchez.asmx?wsdl");
      $CodRespuesta = $EnviarDatos->CrearUsuario([
                                   "NSS"=>$DatosGral[0],
                                   "RFC"=>$DatosGral[1],
                                   "NOMBRE"=>$DatosGral[2],
                                   "PATERNO"=>$DatosGral[3],
                                   "MATERNO"=>$DatosGral[4],
                                   "NUSUARIO"=>$UName,
                                   "PWD"=>$Pwd,
                                   "PUESTO"=>$DatosGral[5],
                                   "EMPRESA"=>$DatosGral[6],
                                   "DEPA_ID"=>$DatosGral[7],
                                   "TELEFONO"=>$Telefono,
                                   "MAIL"=>$Mail
                                 ]);

      switch($CodRespuesta->CrearUsuarioResult){
        case 302:
          $Mensaje  = "El nombre de usuario ya esta en uso, elija otro";
          $Titulo   = "No es posible guardar";
          $TMensaje = "warning";
        break;
        case 0:
          $Mensaje  = "La petición no se pudo procesar, ocurrió un error desconocido en la inserción de datos";
          $Titulo   = "Error interno";
          $TMensaje = "error";
        break;
        default:
          $Mensaje  = "Usuario creado existosamente";
          $Titulo   = "Proceso satisfactorio";
          $TMensaje = "success";
          $NombreCompleto = $DatosGral[2].' '.$DatosGral[3].' '.$DatosGral[4];

          Mail::to($Mail)
               ->send(new EnviarCredenciales($Pwd,$NombreCompleto,$UName));
        break;
      }

      return response()->json(["Codigo"=>$CodRespuesta,"Titulo"=>$Titulo,"Mensaje"=>$Mensaje,"TMensaje"=>$TMensaje]);

    }

    /*==========================================================*/

    public function BColaborador(Request $r){
      $Colaboradores = self::InfoColaboradores($r->input('txtColab'));

      if(sizeof($Colaboradores)>=1){
        $Resultados = '';
          foreach($Colaboradores as $Persona){
            $Resultados .= '<tr>';
            $Resultados .= '<td>'.$Persona->NOMBRE.' '.$Persona->PATERNO.' '.$Persona->MATERNO.'</td>';
            $Resultados .= '<td>'.$Persona->EMPRESA.'</td>';
            $Resultados .= '<td>'.$Persona->NOMBRE_PUESTO.'</td>';
            $Resultados .= '<td>'.$Persona->NOM_DEPARTAMENTO.'</td>';
            $Resultados .= '<td><button class="btn btn-primary btn-xs depaSelect" onclick="depaSelect('.trim($Persona->DEPARTAMENTO_ID).','."'".trim($Persona->NOMBRE)."','".trim($Persona->PATERNO)."','".trim($Persona->MATERNO)."'".','."'".trim($Persona->NOM_DEPARTAMENTO)."'".','."'".trim($Persona->NOMBRE_PUESTO)."'".',';
            $Resultados .= "'".trim($Persona->EMPRESA)."','".trim($Persona->RFC)."','".trim($Persona->NSS)."'".');"  data-dismiss="modal">Seleccionar</button></td>';
            $Resultados .= '</tr>';
          }
      }else{
        $Resultados= '<tr><td colspan="3">No existen resultados para su Busqueda</td></tr>';
      }

      $Tabla = '
      <table class="table table-striped table-bordered table-hover table-full-width">
      <thead>
        <tr>
          <th>COLABORADOR</th>
          <th>EMPRESA</th>
          <th>PUESTO</th>
          <th>DEPARTAMENTO</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';
      $Tabla .=$Resultados."</tbody></table>";
      return response()->json(["Dato"=>$Tabla]);
    }
}
