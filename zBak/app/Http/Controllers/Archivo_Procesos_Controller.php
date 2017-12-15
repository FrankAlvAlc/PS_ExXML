<?php

namespace App\Http\Controllers;
use File;
use DB;
use Illuminate\Http\Request;

class Archivo_Procesos_Controller extends Controller
{
  /*Metodo para obtener los XML*/
  public function archivos_xml($archivo){
    $valor=array();
    foreach ($archivo as $key) {
      if(strtolower($key->getClientOriginalExtension())=='xml'){
            $valor[]=$key;
      }
    }
      return $valor;
  }
    /*Metodo para obtener los PDF*/
  public function archivos_pdf($archivo){
    $valor=array();
    foreach ($archivo as $key) {
      if(strtolower($key->getClientOriginalExtension())=='pdf'){
          $valor[]=$key;
      }
    }
      return $valor;
  }
  /*Metodo para validar que la Cantidad de PDF y XML sean iguales*/
  public function valida_cantidad_archivo($xml,$pdf){
    $cantidad=0;
    if(count($xml)==count($pdf)){
      //El 0 estan igual
        $cantidad=0;
    }else if(count($xml)>count($pdf)){
        //El 2 significa que se tiene mas xml que pdf
        $cantidad=2;
    }else{
      //El 3 significa que se tiene mas pdf que xml
      $cantidad=3;
    }
    return $cantidad;
  }
  /*Funcion que validar que el XML no tenga puntos en el nombre*/
  public function validar_sin_puntos_xml($nombre){
    $nombre_xml=array();
    foreach ($nombre as $ruta) {
        if(strtolower(strstr($ruta->getClientOriginalName(),'.'))==".xml"){
          $nombre_xml[]=array($ruta->getClientOriginalName(),"b");
        }else{
          $nombre_xml[]=array($ruta->getClientOriginalName(),"e");
        }
    }
    return $nombre_xml;
  }
    /*Funcion que validar que el PDF no tenga puntos en el nombre*/
  public function validar_sin_puntos_pdf($nombre){
    $nombre_pdf=array();
    foreach ($nombre as $ruta) {
        if(strtolower(strstr($ruta->getClientOriginalName(),'.'))==".pdf"){
          $nombre_pdf[]=array($ruta->getClientOriginalName(),"b");
        }else{
          $nombre_pdf[]=array($ruta->getClientOriginalName(),"e");
        }
    }
    return $nombre_pdf;
  }
  /*Funcion para validar que se no se tengan errores en los nombres*/
  public function validar_nombre_error($xml,$pdf){
      $nombre_error_xml=array();
      $nombre_bueno_xml=array();
      $nombre_error_pdf=array();
      $nombre_bueno_pdf=array();
      $documento_error=array();
      $documento_bueno=array();
      for($i=0;$i<count($xml);$i++){
          if($xml[$i][1]=="b"){
            $nombre_bueno_xml[]=array($xml[$i][0],"b");
          }else{
            $nombre_error_xml[]=array($xml[$i][0],"e");
          }
      }
      for ($j=0; $j <count($pdf); $j++) {
        if($pdf[$j][1]=="b"){
          $nombre_bueno_pdf[]=array($pdf[$j][0],"b");
        }else{
          $nombre_error_pdf[]=array($pdf[$j][0],"e");
        }
      }
      if(count($nombre_error_pdf)!=0 && count($nombre_error_xml)!=0 && count($nombre_bueno_pdf)!=0 && count($nombre_bueno_xml)!=0){
          $documento_error=array_merge($nombre_error_xml,$nombre_error_pdf);
          $documento_bueno=array_merge($nombre_bueno_xml,$nombre_bueno_pdf);
      }else if(count($nombre_error_pdf)==0 && count($nombre_error_xml)==0 && count($nombre_bueno_pdf)!=0 && count($nombre_bueno_xml)!=0){
          $documento_bueno=array_merge($nombre_bueno_xml,$nombre_bueno_pdf);
      }else {
          $documento_error=array_merge($nombre_error_xml,$nombre_error_pdf);
      }
      if(count($documento_error)>0){
            return 1;
      }else {
            return 0;
      }
  }
  /*Metodo creado para verificar si existe las carpetas*/
  public function verifica_carpeta($name){
    $ruta=array();
      if (File::exists('/archivos'.'/'.strtoupper($name))){
          $ruta[]=array('/archivos'.'/'.strtoupper($name),'SI');
      }else {
          $ruta[]=array('/archivos'.'/'.strtoupper($name),'NO');
      }
    return $ruta;
  }
  /*Metodo para crear carpeta*/
  public function crear_carpeta($datos){
    $creada=0;
    $Nocreada=0;
    $valor="";
    /*Dentro del metodo se returnan dos valores 1 y 0
    los valores return tienen como funcion lo siguiente:
    0 => La carpeta fue creada
    1 => la carpeta no Fue creada*/
    for($i=0;$i<count($datos);$i++){
         if($datos[$i][1]=="NO"){
            File::makeDirectory($datos[$i][0], 0777, true, true);
            return 0;
          }else{
            return 1;
          }
     }
  }
  /*Funcion para validar que se tengan nombre iguales*/
  public function validar_nombre_igual($xml,$pdf){
    $nombre_xml=array();
    $nombre_pdf=array();
    $x=0;
    $j=0;
    foreach ($xml as $nombre) {
        if(strtolower(strstr($nombre->getClientOriginalName(),'.'))==".xml"){
          $nombre_xml[]=array($x=>strstr($nombre->getClientOriginalName(),'.',true));
          $x++;
        }
    }
    foreach ($pdf as $nom) {
        if(strtolower(strstr($nom->getClientOriginalName(),'.'))==".pdf"){
          $nombre_pdf[]=array($j=>strstr($nom->getClientOriginalName(),'.',true));
          $j++;
        }
    }
    $cantidad_pdf=count($nombre_pdf);
    $cantidad_xml=count($nombre_xml);
    $arreglo = array_map("unserialize", array_intersect(self::serialize_array_values($nombre_pdf),self::serialize_array_values($nombre_xml)));
    $cantidad_iguales=count($arreglo);
    /*Condicion para validar que los nombres sean iguales
    el return regresa ciertas variables las cuales tienen la siguiente funciones
    1 => Los Archivos XML y PDF tienen el mismo nombre
    0 => Se tienen Archivos con Nombre Distintos*/
    if($cantidad_pdf==$cantidad_iguales && $cantidad_xml==$cantidad_iguales){
      return 1;
    }else {
      return 0;
    }
  }
  /*Se adapta los datos para que sean aceptado por el areglo y asi pode ser comparados*/
  public function serialize_array_values($arr){
      foreach($arr as $key=>$val){
        sort($val);
        $arr[$key]=serialize($val);
      }

    return $arr;
  }
  /*Obtener el nombre del archivo de los XML*/
  public function obtener_nombre($archivos){
    $json="";
    $arreglo=array();
    $arreglo1=array();
    $arreglo2=array();
    $arreglo3=array();
    $arreglo4=array();
    $x=0;
    $documento1=array();
    $dato="";
    foreach ($archivos as $key => $value) {
        $arreglo[$x]=array("ruta"=>$value->getClientOriginalName());
        $contenido=File::get($value);
        $json='<pre>' . str_replace('<', '&lt;', $contenido) . '</pre>';
        $xml = new \SimpleXMLElement($json,true);
        $doc = new \DOMDocument();
        $documento=simplexml_load_string($xml);
        // Empieza a recorrer el CFDI y guardar los arreglos
        foreach ($documento->xpath('//cfdi:Comprobante') as $cfdiComprobante){
          $arreglo1[$x]=array("fecha"=>substr($cfdiComprobante['fecha']==""?$cfdiComprobante['Fecha']:$cfdiComprobante['fecha'],0,10));
        }
        foreach ($documento->xpath('//cfdi:Receptor') as $cfdiReceptor){
          $arreglo2[$x]=array("Receptor"=>$cfdiReceptor['rfc']==""?$cfdiReceptor['Rfc']:$cfdiReceptor['rfc']);
        }
        foreach ($documento->xpath('//cfdi:Emisor') as $cfdiEmisor){
          $arreglo3[$x]=array("emisor"=>$cfdiEmisor['rfc']==""?$cfdiEmisor['Rfc']:$cfdiEmisor['rfc']);
        }
        $doc = dom_import_simplexml($documento);
        foreach ($doc->getElementsByTagName('TimbreFiscalDigital') as $elemento) {
          $nombre=implode($arreglo[$x]);
          $emisor=implode($arreglo3[$x]);
          $receptor=implode($arreglo2[$x]);
          $fecha=implode($arreglo1[$x]);
          $uuid=$elemento->getAttribute('UUID');
          $nombre_new=$fecha.'_'.$emisor.'_'.$receptor.'_'.$uuid;
          $arreglo4[$x]=array("nombre"=>$nombre,"emisor"=>$emisor,"Receptor"=>$receptor,"fecha"=>$fecha,"UUID"=>$uuid,"Nombre_nuevo"=>$nombre_new);
        }
        $x++;
    }
    return $arreglo4;
  }
  /*Metodo para Guardar los xml en su carpeta*/
  public function guardar_xml($xml,$nombre,$Repositorio){

      $renombrar_xml=array();
      $destino =$Repositorio;
      $x=0;
      $cnt=count($nombre);
      foreach($xml as $file) {
        $filename = $file->getClientOriginalName();
        $ext= $file->getClientOriginalExtension();

        $Emisor = $nombre[$x]['emisor'];
        $destino=$Repositorio.$Emisor;
        if(File::exists($destino)){
          $destino=$Repositorio.$Emisor;
        }else{
          File::makeDirectory($destino, 0777, true, true);
        }
        $file->move($destino, $filename);
        $renombrar_xml[]=array("nuevo"=>"$destino/".$nombre[$x]['Nombre_nuevo'].'.'.$ext,"viejo"=>$destino.'/'.$filename,$x);
        $x++;
      }
      for($v=0;$v<count($renombrar_xml);$v++){
        rename($renombrar_xml[$v]['viejo'],$renombrar_xml[$v]['nuevo']);
      }
    return $renombrar_xml;
  }
  /*Metodo para Guardar los xml en su carpeta*/
  public function guardar_pdf($pdf,$nombre,$Repositorio){
      $renombrar_pdf=array();
      $destino =$Repositorio;
      $x=0;
      $cnt=count($nombre);
      foreach($pdf as $file) {
        $filename = $file->getClientOriginalName();
        $ext= $file->getClientOriginalExtension();
        $Emisor = $nombre[$x]['emisor'];
        $destino=$Repositorio.$Emisor;
        if(File::exists($destino)){
          $destino=$Repositorio.$Emisor;
        }else{
          File::makeDirectory($destino, 0777, true, true);
        }        
        $file->move($destino,$filename);
        $renombrar_pdf[]=array("nuevo"=>"$destino/".$nombre[$x]['Nombre_nuevo'].'.'.$ext,"viejo"=>$destino.'/'.$filename,$x);
        $x++;
      }
      for($v=0;$v<count($renombrar_pdf);$v++){
        rename($renombrar_pdf[$v]['viejo'],$renombrar_pdf[$v]['nuevo']);
      }
    return $renombrar_pdf;
  }


  /*Metodo para validar el receptor este permitido*/
  public function receptor_permitido($xml,$usuario){
    $aceptadas=0;
    $rechazado=0;
    for($x=0;$x<count($xml);$x++){
        if(self::consulta_factura($xml[$x]['Receptor'],$usuario)>0){
          $aceptadas=$aceptadas+1;
        }else{
          $rechazado=$rechazado+1;
        }
    }
    if($rechazado>0){
        return 1;
    }else{
        return 0;
    }
  }
  /*Metodo para verificar si tiene permitido ese receptor el proveedor*/
  public function consulta_factura($receptor,$usuario){
      $dato_proveedor = DB::table('datos_proveedor')
                        ->where('usuario_rfc','=',$usuario)
                        ->where('rfc_empresa','=',$receptor)
                        ->get();
      return sizeof($dato_proveedor);
  }
  /*Metodo encargado de validar que el Emisor de los XML sea el correcto*/
  public function validar_emisor($xml,$usuario){
      $aceptado=0;
      $rechazado=0;
      $dato="";
      for($x=0;$x<count($xml);$x++){
        if($usuario==$xml[$x]['emisor']){
            $aceptado++;
            $dato=$xml[$x]['emisor'];
        }else{
            $rechazado++;
        }
      }
      if($rechazado>0){
          return 1;
      }else {
        return 0;
      }
  }
}
