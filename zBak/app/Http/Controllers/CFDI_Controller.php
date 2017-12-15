<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Archivo_Procesos_Controller;
use Illuminate\Support\Facades\Input;
use Zipper;
use File;

class CFDI_Controller extends Controller
{
   public function index(){
      $CMenu = new Menu_Principal_Controller;
      $MenuPrincipal = $CMenu->MenuPrincipal();
      return view('carga_masiva_cfdi',compact('MenuPrincipal'));
    }

   /*=============================================================*/
      public function Cargar_Archivos(Request $r){

          $clase=new Archivo_Procesos_Controller;

          $file=array();
          $file= Input::file('file-1');
          if(count($file)>0){

            /*Variable creada para obtener los PDF*/
            $pdf=array();
            $pdf=$clase->archivos_pdf($file);

            /*Variable creada para obtener los XML*/
            $xml=array();
            $xml=$clase->archivos_xml($file);

            /*Variable creara para obtener todos los nombre*/
            $cantidad=$clase->valida_cantidad_archivo($xml,$pdf);

            /*Se crearon variables de session para mostrar ciertas condiciones, por lo que
            la variables de session archivo tiene los siguientes parametros

             1 => Te informa que el archivo contiene puntos
             2 => Te informa que contenemos mas xml que pdf
             3 => Te informa que contenemos mas PDF que XML

    		 en la siguiente condicion valida que las cantidades de archivos sean iguales
             y que la estructura sea la correcta*/
            if($cantidad==0){

                /*Validamos que los PDF  no contengan puntos*/
                $sin_punto_pdf=$clase->validar_sin_puntos_pdf($pdf);

                  /*Validamos que los XML  no contengan puntos*/
                $sin_punto_xml=$clase->validar_sin_puntos_xml($xml);


                /*Se valida que el nombre de los pdf y xml no tengan errores*/
                $valida_nombre=$clase->validar_nombre_error($sin_punto_xml,$sin_punto_pdf);
                if($valida_nombre==0){

                    $carpeta=array();

                    $Repositorio = 'archivos/Sanchez_MX_Repo_'. request()->cookie('Usuario_ID').'/';

                    if (File::exists($Repositorio)){
                      File::deleteDirectory(public_path($Repositorio));
                      File::makeDirectory($Repositorio, 0777, true, true);
                    }else{
                      File::makeDirectory($Repositorio, 0777, true, true);
                    }
                    //$carpeta=$clase->verifica_carpeta($Repositorio);

                    $crear_folder=1;
                    if($crear_folder==0 || $crear_folder==1){
                      $nombre_igual=array();
                      $nombre_igual=$clase->validar_nombre_igual($xml,$pdf);
                      if($nombre_igual==1){
                        /*Metodo y Variable creada para obtener los datos de los XML*/
                          $datos_xml=array();
                          $datos_xml=$clase->obtener_nombre($xml);
                          /*Metodo creado para verificar que las facturas no hayan sido subida anteiormentes*/
                          $recep_permitido=0;
                          if($recep_permitido==0){
                            /*Metodo creado para verificar que las facturas correspondan al emisor que esta subiendo, la factura*/
                            $validar_emisor=0;
                            if($validar_emisor==0){
                                $clase->guardar_pdf($pdf,$datos_xml,$Repositorio);
                                $clase->guardar_xml($xml,$datos_xml,$Repositorio);



                                if(strlen($r->input('txtPaquete'))==0){
                                $ZipName = 'Paquete_Archivos.zip';
                                }else{
                                  $ZipName = $r->input('txtPaquete').'.zip';
                                }

                                $files = glob(public_path($Repositorio));
                                Zipper::make($Repositorio.$ZipName)->add($files);
                                Zipper::close();
                                if(File::exists($Repositorio.$ZipName)){
                                     return response()->download(public_path($Repositorio.$ZipName));
                                 }
                                //return redirect('/CFDI/Renombrar')->with('carga','Archivos Cargados');
                            }else{
                              return redirect('/CFDI/Renombrar')->with('carga','Se tiene facturas con Emisor, que no son permitidas');
                            }
                          }else{
                            return redirect('/CFDI/Renombrar')->with('carga','Se tiene Facturas con Receptor que no son permitidas');
                          }
                      }else{
                        return redirect('/CFDI/Renombrar')->with('carga','La Carga fue cancelada, Hay archivos que no tienen el mismo nombre');
                      }
                    }else{
                      return redirect('/CFDI/Renombrar')->with('carga','Error Interno');
                    }
                }else {
                  return redirect('/CFDI/Renombrar')->with('punto','Archivos no cargados, Se tienen Archivos que contienen Punto en su nombre, y no son valido');
                }
            }else if($cantidad==2){
              return redirect('/CFDI/Renombrar')->with('xml','Se contienen mas Archivos XML que PDF');
            }else{
              return redirect('/CFDI/Renombrar')->with('pdf','Se contienen mas Archivos PDF que XML');
            }
        }else{
          return redirect('/CFDI/Renombrar')->with('archivo_vacio','No se Tiene Seleccionado ningun Archivo');
        }
      }

}
