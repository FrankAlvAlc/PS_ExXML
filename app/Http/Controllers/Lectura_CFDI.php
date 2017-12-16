<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use File;

class Lectura_CFDI extends Controller
{

    public function index(){
     $CMenu = new Menu_Principal_Controller;
     $MenuPrincipal = $CMenu->MenuPrincipal();
     return view('carga_masiva_cfdi',compact('MenuPrincipal'));
   }

   /*===========================================================================*/

   public function Cargar_Archivos(Request $r){

    $file=array();
    $file= Input::file('file-1');
    $Datos = array();
    $X=0;
    $destino =public_path() .'/Repo/';
    if(count($file)>0){

      foreach ($file as $value) {
        $filename=$value->getClientOriginalName();
        $value->move($destino,$filename);
        try{
          $Datos[$X] = self::ObtenerInfo($destino.$filename);
          $Emisor = $Datos[$X]["rfc"];
          $Receptor = $Datos[$X]["rfc_receptor"];
          $uuid= $Datos[$X]["uuid"];
          $Conceptos = $Datos[$X]['Conceptos'];
          echo $destino.$Emisor."_".$Receptor."_".$uuid.".xml<br>";
          rename($destino.$filename,$destino.$Emisor."_".$Receptor."_".$uuid.".xml");

        }catch(\Exception $e){
          echo "Ocurrio un error en el archivo ".$filename.". Mensaje del sistema: ".$e->getMessage();
        }
        $X++;
      }

dd($Conceptos);

    }else{
      echo "No ha cargado ningun archivo";
    }


}

  /*===========================================================================*/

    public function ObtenerInfo($xml){
      $texto = file_get_contents($xml);

      //Borrar Bit Only Mark (BOM)
      if( substr($texto, 0,3) == pack("CCC",0xef,0xbb,0xbf) ) {
          $texto = substr($texto, 3);
          echo "<h3>Tenia BOM, Eliminado!</h3>";
      }
      if (!mb_check_encoding($texto,"utf-8")) {
          echo "<h3>Error en XML, no esta en UTF-8!</h3>";
      }
      $nuevo = utf8_decode($texto);
      if (mb_check_encoding($nuevo,"utf-8") && $nuevo != $texto) {
          echo "<h3>Sigue siendo utf8, usa decode</h3>";
          $texto = $nuevo;
      }

      $texto = preg_replace('{<Addenda.*/Addenda>}is', '', $texto);
      $texto = preg_replace('{<cfdi:Addenda.*/cfdi:Addenda>}is', '', $texto);
      libxml_use_internal_errors(true);

      $xml = new \DOMDocument();
      $ok = $xml->loadXML($texto);
      if (!$ok) {
         display_xml_errors();
         die();
      }

      if (strpos($texto,"cfdi:Comprobante")!==FALSE) {
          $tipo="cfdi";
      } elseif (strpos($texto,"<Comprobante")!==FALSE) {
          $tipo="cfd";
      } elseif (strpos($texto,"retenciones:Retenciones")!==FALSE) {
          $tipo="retenciones";
      } else {
          return ("Tipo de XML no identificado ....");
      }

      //   Con el arbol DOM buscamos los atributos
      if ($tipo=="retenciones") {
          $root = $xml->getElementsByTagName('Retenciones')->item(0);
          $Version = $root->getAttribute("Version");
      } else {
          $root = $xml->getElementsByTagName('Comprobante')->item(0);
          $version = $root->getAttribute("version");//Version con "V" Minuscula
          if ($version==null) $version = $root->getAttribute("Version");//Version con "V" Mayuscula
      }
      $Receptor = $root->getElementsByTagName('Receptor')->item(0);
      $Emisor = $root->getElementsByTagName('Emisor')->item(0);

      $data['seri'] = $root->getAttribute("serie");
      $data['fecha'] = $root->getAttribute("fecha");
      $data['noap'] = $root->getAttribute("noAprobacion");
      $data['anoa'] = $root->getAttribute("anoAprobacion");

      $data['tipo']=$tipo;
      if ($tipo=="retenciones") {
          $rfc = $Emisor->getAttribute('RFCEmisor');
          $data['rfc'] = utf8_decode($rfc);
          $rfc = $Receptor->getAttribute('RFCRecep');
          $data['rfc_receptor'] = utf8_decode($rfc);
          $data['version'] = $root->getAttribute("Version");
          $data['no_cert'] = $root->getAttribute("NumCert");
          $data['cert'] = $root->getAttribute("Cert");
          $data['sell'] = $root->getAttribute("Sello");
          $Totales = $root->getElementsByTagName('Totales')->item(0);
          $data['total'] = $Totales->getAttribute("montoTotGrav");
      } else {
          $data['version'] = $version;
          if ($version=="3.3") { // Mayusculas
              $data['total'] = $root->getAttribute('Total');
              $data['no_cert'] = $root->getAttribute('NoCertificado');
              $data['cert'] = $root->getAttribute('Certificado');
              $data['sell'] = $root->getAttribute('Sello');
              $rfc = $Emisor->getAttribute('Rfc');
              $data['rfc'] = utf8_decode($rfc);
              $rfc = $Receptor->getAttribute('Rfc');
              $data['rfc_receptor'] = utf8_decode($rfc);
          } else { // NO es 3.3, es 3.2 o anterior minusculas
              $data['total'] = $root->getAttribute('total');
              $data['no_cert'] = $root->getAttribute('noCertificado');
              $data['cert'] = $root->getAttribute('certificado');
              $data['sell'] = $root->getAttribute('sello');
              $rfc = $Emisor->getAttribute('rfc');
              $data['rfc'] = utf8_decode($rfc);
              $rfc = $Receptor->getAttribute('rfc');
              $data['rfc_receptor'] = utf8_decode($rfc);
          } // version 3.3
      } // Retencion o CFDI
      


foreach ($root->getElementsByTagName('Concepto') as $element) {
  echo 'UUID: '. $element->getAttribute('ClaveProdServ').','.$element->getAttribute('NoIdentificacion').','.$element->getAttribute('Cantidad').'<br>';
//NoIdentificacion Cantidad ClaveUnidad Unidad Descripcion ValorUnitario Importe
  $data['Conceptos'] = 'ClaveProdServ: '. $element->getAttribute('ClaveProdServ');
}
foreach ($root->getElementsByTagName('Traslado') as $element) {
  echo 'UUID: '. $element->getAttribute('Base').','.$element->getAttribute('Impuesto').','.$element->getAttribute('TipoFactor').'<br>';
//NoIdentificacion Cantidad ClaveUnidad Unidad Descripcion ValorUnitario Importe
  $data['Conceptos'] = 'ClaveProdServ: '. $element->getAttribute('Base');
}

    /*  foreach ($root->getElementsByTagName('Conceptos') as $Emisor){  // SECCION EMISOR
    $data['Conceptos']            = $Emisor['ClaveProdServ'];

  }*/

      $TFD = $root->getElementsByTagName('TimbreFiscalDigital')->item(0);
      if ($TFD!=null) {
          $data['version_tfd'] = $TFD->getAttribute("Version");
          if ($data['version_tfd'] == "") $data['version_tfd'] =  $TFD->getAttribute("version");
          if ($data['version_tfd'] == "1.0") {
              $data['sellocfd'] = $TFD->getAttribute("selloCFD");
              $data['sellosat'] = $TFD->getAttribute("selloSAT");
              $data['no_cert_sat'] = $TFD->getAttribute("noCertificadoSAT");
          } else {
              $data['sellocfd'] = $TFD->getAttribute("SelloCFD");
              $data['sellosat'] = $TFD->getAttribute("SelloSAT");
              $data['no_cert_sat'] = $TFD->getAttribute("NoCertificadoSAT");
          }
          $data['uuid'] = $TFD->getAttribute("UUID");
      } else {
          $data['sellocfd'] = null;
          $data['sellosat'] = null;
          $data['no_cert_sat'] = null;
          $data['uuid'] = null;
      }

      return $data;
    }

    /*==========================================================================*/


    public function valida_xsd() {
        /*
         * Todos los archivos que se requieren para hacer la validacion
         * fueron descargados del portal del SAT para que las validaciones sean mas rapidas.
         *
         */
    global $data, $xml,$texto;
    libxml_use_internal_errors(true);
    if ($data['tipo']=="retenciones") {
        switch ($data['version']) {
          case "1.0":
            echo "Version 1.0 Retenciones<br>";
            $ok = $xml->schemaValidate("Recursos/xsd/retencionpagov1.xsd");
            break;
          default:
            $ok = false;
            echo "Version invalida $tipo ".$data['version']."<br>";
        }
    } else {
        switch ($data['version']) {
          case "2.0":
            echo "Version 2.0 CFD<br>";
            $ok = $xml->schemaValidate("Recursos/xsd/cfdv2complemento.xsd");
            break;
          case "2.2":
            echo "Version 2.2 CFD<br>";
            $ok = $xml->schemaValidate("Recursos/xsd/cfdv22complemento.xsd");
            break;
          case "3.0":
            echo "Version 3.0 (CFDI)<br>";
            $ok = $xml->schemaValidate("Recursos/xsd/cfdv3complemento.xsd");
            break;
          case "3.2":
            echo "Version 3.2 CFDI<br>";
            $ok = $xml->schemaValidate("Recursos/xsd/cfdv32.xsd");
            break;
          case "3.3":
            echo "Version 3.3 CFDI<br>";
            $ok = $xml->schemaValidate("Recursos/xsd/cfdv33.xsd");
            break;
          default:
            $ok = false;
            echo "Version invalida $tipo ".$data['version']."<br>";
        }
    }
    if ($ok) {
        echo "<h3>Esquema valido</h3>";
    } else {
        echo "<h3>Estructura contra esquema incorrecta</h3>";
        display_xml_errors();
    }
    echo "<hr>";
    }

/*==============================================================================*/

    public function semantica_ine() {
        global $xml, $conn;
        echo "<h2>Semantica INE</h2>";
        require_once("Recursos/semantica_ine.php");
        $ine = new Ine();
        $ine->valida($xml,$conn);
        echo "<h2>$ine->status</h2>";
    }

/*==============================================================================*/

  public function semantica_cce() {
        global $xml, $conn;
        echo "<h2>Semantica CCE</h2>";
        require_once("Recursos/semantica_cce.php");
        $cce = new Cce();
        $cce->valida($xml,$conn);
        echo "<h2>$cce->codigo</h2>";
        echo "<hr/>";
    }

/*==============================================================================*/

  public function semantica_cce11() {
        global $xml, $conn;
        echo "<h2>Semantica CCE Version 1.1</h2>";
        require_once("Recursos/semantica_cce11.php");
        $cce = new Cce11();
        $cce->valida($xml,$conn);
        echo "<h2>".str_replace("; ","<br>",$cce->status)."</h2>";
        echo "<hr/>";
    }

/*==============================================================================*/

  public function semantica_nomi12() {
        global $xml, $conn;
        echo "<h2>Semantica NOMINA 12</h2>";
        require_once("Recursos/semantica_nomi12.php");
        $nomi = new Nomi12();
        $nomi->valida($xml,$conn);
        echo "<h2>".str_replace("; ","<br>",$nomi->status)."</h2>";
        echo "<hr/>";
    }

/*==============================================================================*/

  public function semantica_pago10() {
        global $xml, $conn;
        echo "<h2>Semantica Pagos 1.0</h2>";
        require_once("Recursos/semantica_pagos10.php");
        $pago = new Pagos10();
        $pago->valida($xml,$conn);
        echo "<h2>$pago->codigo</h2>";
        echo "<hr/>";
    }

/*==============================================================================*/

    public function semantica_cfdi() {
        global $xml, $conn;
        echo "<h2>Semantica CFDI 3.3</h2>";
        require_once("Recursos/semantica_cfdi.php");
        $sem = new Sem_CFDI();
        $sem->valida($xml,$conn);
        echo "<h2>$sem->codigo</h2>";
        echo "<hr/>";
    }

/*==============================================================================*/

  public function valida_sello() {
      /*
       * Todos los archivos que se requieren para hacer la validacion
       * fueron descargados del portal del SAT para que las validaciones sean mas rapidas.
       *
       */
    global $data, $xml;

    $xsl = new \DOMDocument;
    if ($data['tipo']=="retenciones") {
        switch ($data['version']) {
          case "1.0":
              $xsl->load('Recursos/xslt/retenciones.xslt');
              $algo =OPENSSL_ALGO_SHA1;
              break;
          default:
              echo "version incorrecta ".$data['tipo']." ".$data['version']."\n";
              break;
        }
    } else {
        switch ($data['version']) {
          case "2.0":
              $xsl->load('Recursos/xslt/cadenaoriginal_2_0.xslt');
              if (substr($data['fecha'],0,4)<2011) {
                  echo "md5 \n";
                  $algo = OPENSSL_ALGO_MD5;
              } else {
                  echo "sha1 \n";
                  $algo =OPENSSL_ALGO_SHA1;
              }
              break;
          case "2.2":
              echo "2.2\n";
              $xsl->load('Recursos/xslt/cadenaoriginal_2_2.xslt');
              echo "sha1 \n";
              $algo = OPENSSL_ALGO_SHA1;
              break;
          case "3.0":
              $xsl->load('Recursos/xslt/cadenaoriginal_3_0.xslt');
              if (substr($data['fecha'],0,4)<2011) {
                  echo "md5 \n";
                  $algo = OPENSSL_ALGO_MD5;
              } else {
                  echo "sha1 \n";
                  $algo =OPENSSL_ALGO_SHA1;
              }
              break;
          case "3.2":
              echo "3.2\n";
              $xsl->load('Recursos/xslt/cadenaoriginal_3_2.xslt');
              echo "sha1 \n";
              $algo = OPENSSL_ALGO_SHA1;
              break;
          case "3.3":
              echo "3.3\n";
              $xsl->load('Recursos/xslt/cadenaoriginal_3_3.xslt');
              echo "sha256 \n";
              $algo = OPENSSL_ALGO_SHA256;
              break;
          default:
              echo "version incorrecta ".$data['tipo']." ".$data['version']."\n";
              break;
        }
    }


    /*
     * El domicilio es opcional, pero si no lo ponemos el xslt del SAT genera
     * doble pip en el pais ..., dice que el sello es correcto pero los PACs
     * que validan bien lo rechazan ...
     * */
    $doble = preg_match('/.\|\|./',$cadena);
    if ($doble===1) {
        echo "<h3><font color=red>La cadena tiene doble pipes en medio ...</font></h3>";
    }
    // Primer certificado (o unico) del emisor
    // Los demas certificados es del PAC, Timbre, etc.
    $pem = (sizeof($data['cert'])<=1) ? $data['cert'] : $data['cert'][0];

    $pem = preg_replace("/[\n|\r|\n\r]/", '', $pem);
    $pem = preg_replace('/\s\s+/', '', $pem);
    // Si no incluye el certificado bajarlo del FTP del sat ....
    if (strlen($pem)==0) {
        echo "No incluye certificado interno, descargarlo del FTP del sat ...<br>";

        $pem=get_sat_cert($data['no_cert']);

    }

    $cert = "-----BEGIN CERTIFICATE-----\n".chunk_split($pem,64)."-----END CERTIFICATE-----\n";
    $pubkeyid = openssl_get_publickey(openssl_x509_read($cert));
    if (!$pubkeyid) {
        echo "Certificado interno Incorrecto, descargarlo del FTP del sat ...<br>";
        $pem=get_sat_cert($data['no_cert']);
        $cert = "-----BEGIN CERTIFICATE-----\n".chunk_split($pem,64)."-----END CERTIFICATE-----\n";
        $pubkeyid = openssl_get_publickey(openssl_x509_read($cert));

    }
    //valida_pubkey(openssl_x509_read($cert));

    openssl_free_key($pubkeyid);
    echo "<hr>";
    $paso = openssl_x509_parse($cert);
    $serial = convierte($paso['serialNumber']);
    if ($serial!=$data['no_cert']) {
        echo "Serie reportada ".$data['no_cert']." serie usada $serial<br>";
    }

    }

/*==============================================================================*/

  public function valida_sello_tfd() {
    global $data, $texto;

    if ($data['sell'] != $data['sellocfd']) {
        echo "<h3>sello Comprobante diferente que sello TFD!, manipulado?</h3>";
    }

    // Quita la parte del CFDI
    $texto_tfd = preg_replace('{<cfdi:Comprobante.*<tfd:}is', '<tfd:', $texto);
    $texto_tfd = preg_replace('{<retenciones:Retenciones.*<tfd:}is', '<tfd:', $texto_tfd);
    $texto_tfd = trim(preg_replace('{/>.*$}is', '/>', $texto_tfd));
    // Si no tiene el namespace definido, se agrega
    if (strpos($texto_tfd,"xmlns:tfd")===FALSE) {

        $texto_tfd = substr($texto_tfd,0,-2).' xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" />';
    }
    // echo htmlspecialchars($texto_tfd);
    // Solo se quedo el tfd:
    $xml_tfd = new \DOMDocument();
    $ok = $xml_tfd->loadXML($texto_tfd);

    $xsl = new \DOMDocument;
    if ($data['version_tfd'] == "1.0") {
        $xsl->load('Recursos/xslt/cadenaoriginal_TFD_1_0.xslt');
        $alg = OPENSSL_ALGO_SHA1;
    } else {
        $xsl->load('Recursos/xslt/cadenaoriginal_TFD_1_1.xslt');
        $alg = OPENSSL_ALGO_SHA256;
    }

    // Certificado del PAC

    echo "<hr>";

    }
/*==============================================================================*/
// ftp://ftp2.sat.gob.mx/asistencia_servicio_ftp/publicaciones/cfdi/WS_ConsultaCFDI.pdf
  public  function valida_en_sat() {
        global $data;
        $url = "https://consultaqr.facturaelectronica.sat.gob.mx/consultacfdiservice.svc?wsdl";
        $soapclient = new SoapClient($url);
        $rfc_emisor = utf8_encode($data['rfc']);
        $rfc_receptor = utf8_encode($data['rfc_receptor']);
        $impo = (double)$data['total'];
        $impo=sprintf("%.6f", $impo);
        $impo = str_pad($impo,17,"0",STR_PAD_LEFT);
        $uuid = strtoupper($data['uuid']);
        $factura = "?re=$rfc_emisor&rr=$rfc_receptor&tt=$impo&id=$uuid";
        echo "<h3>$factura</h3>";
        $prm = array('expresionImpresa'=>$factura);
        $buscar=$soapclient->Consulta($prm);
        echo "<h3>El portal del SAT reporta</h3>";
        echo "El codigo: ".$buscar->ConsultaResult->CodigoEstatus."<br>";
        echo "El estado: ".$buscar->ConsultaResult->Estado."<br>";

    }

/*==============================================================================*/

public function convierte($dec) {
        $hex=bcdechex($dec);
        $ser="";
        for ($i=1; $i<strlen($hex); $i=$i+2) {
            $ser.=substr($hex,$i,1);
        }
        return $ser;
    }
/*==============================================================================*/
    // {{{ bcdechex   :  como dechex pero para numeros de precision ilimitada
  public function bcdechex($dec) {
        $last = bcmod($dec, 16);
        $remain = bcdiv(bcsub($dec, $last), 16);
        if($remain == 0) {
            return dechex($last);
        } else {
            return bcdechex($remain).dechex($last);
        }
    }
/*==============================================================================*/
    // {{{ display_xml_errors
    public function display_xml_errors() {
        global $texto;
        $lineas = explode("\n", $texto);
        $errors = libxml_get_errors();

        echo "<pre>";
        foreach ($errors as $error) {
            echo display_xml_error($error, $lineas);
        }
        echo "</pre>";

        libxml_clear_errors();
    }
/*==============================================================================*/
    // {{{ display_xml_error
  public function display_xml_error($error, $lineas) {
        $return  = htmlspecialchars($lineas[$error->line - 1]) . "\n";
        $return .= str_repeat('-', $error->column) . "^\n";

        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "Warning $error->code: ";
                break;
             case LIBXML_ERR_ERROR:
                $return .= "Error $error->code: ";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "Fatal Error $error->code: ";
                break;
        }

        $return .= trim($error->message) .
                   "\n  Linea: $error->line" .
                   "\n  Columna: $error->column";
        echo "$return\n\n--------------------------------------------\n\n";
    }
}
