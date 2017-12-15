<?php

namespace App\Http\Controllers;
use File;
use DB;
use Illuminate\Http\Request;

class Archivo_Procesos_Controller extends Controller
{
  
  /*Obtener el nombre del archivo de los XML*/
  public function obtener_nombre(){

    $deleted = DB::delete('DELETE FROM exports');

    $arreglo=array();
    $arreglo1=array();
    $arreglo2=array();
    $arreglo3=array();
    $arreglo4=array();
    $arreglo5=array();
    $arreglo6=array();
    $arreglo7=array();
    $arreglo8=array();
    $arreglo9=array();
    $arreglo10=array();
    $arreglo11=array();
    $arreglo12=array();
    $arreglo13=array();
    $arreglo14=array();
    $arreglo15=array();
    $arreglo16=array();

    $documento1=array();
    $i = 1;
    $x=1;

    $directorio = '//Xml/vsg080207hb82/2017/01 ACREEDORES/PF/';
    $ficheros1  = scandir($directorio);
    unset($ficheros1[0]);
    unset($ficheros1[1]);
    
    foreach ($ficheros1 as &$valor) {

      $documento = simplexml_load_file($directorio . $valor);   

      foreach ($documento->xpath('//cfdi:Emisor') as $cfdiEmisor){
        $arreglo2[$x]=array("RFC"=>$cfdiEmisor['rfc']==""?$cfdiEmisor['Rfc']:$cfdiEmisor['rfc']);
        $arreglo3[$x]=array("NOMBRE"=>$cfdiEmisor['nombre']==""?$cfdiEmisor['Nombre']:$cfdiEmisor['nombre']);  
      }

      foreach ($documento->xpath('//cfdi:DomicilioFiscal') as $cfdiDomicilioFiscal){
        $arreglo4[$x]=array("CALLE"=>$cfdiDomicilioFiscal['calle']==""?$cfdiDomicilioFiscal['Calle']:$cfdiDomicilioFiscal['calle']);
        $arreglo5[$x]=array("NUMERO"=>$cfdiDomicilioFiscal['noExterior']==""?$cfdiDomicilioFiscal['NoExterior']:$cfdiDomicilioFiscal['noExterior']);
        $arreglo6[$x]=array("CP"=>$cfdiDomicilioFiscal['codigoPostal']==""?$cfdiDomicilioFiscal['CodigoPostal']:$cfdiDomicilioFiscal['codigoPostal']);
        $arreglo7[$x]=array("POB_COL"=>$cfdiDomicilioFiscal['colonia']==""?$cfdiDomicilioFiscal['Colonia']:$cfdiDomicilioFiscal['colonia']);
        $arreglo8[$x]=array("DIS_MUN"=>$cfdiDomicilioFiscal['municipio']==""?$cfdiDomicilioFiscal['Municipio']:$cfdiDomicilioFiscal['municipio']);
        $arreglo9[$x]=array("PAIS"=>$cfdiDomicilioFiscal['pais']==""?$cfdiDomicilioFiscal['Pais']:$cfdiDomicilioFiscal['pais']);
        $arreglo10[$x]=array("ESTADO"=>$cfdiDomicilioFiscal['estado']==""?$cfdiDomicilioFiscal['Estado']:$cfdiDomicilioFiscal['estado']);
        $arreglo11[$x]=array("LOCALIDAD"=>$cfdiDomicilioFiscal['localidad']==""?$cfdiDomicilioFiscal['Localidad']:$cfdiDomicilioFiscal['localidad']);
      }

      foreach ($documento->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
        $arreglo12[$x]=array("MET_PAG"=>$cfdiComprobante['metodoDePago']==""?$cfdiComprobante['MetodoDePago']:$cfdiComprobante['metodoDePago']);
        $arreglo13[$x]=array("MET_PAG"=>$cfdiComprobante['metodoPago']==""?$cfdiComprobante['MetodoPago']:$cfdiComprobante['metodoPago']);
        $arreglo16[$x]=array("MET_PAG"=>$cfdiComprobante['metodoPago']==""?$cfdiComprobante['MetodoPago']:$cfdiComprobante['metodoPago']);
      }

      $ns = $documento->getNamespaces(true);
      $documento->registerXPathNamespace('t', $ns['tfd']);

      foreach ($documento->xpath('//t:TimbreFiscalDigital') as $tfd) {
         $UUIDX = $tfd['UUID']; 
      } 

      foreach ($documento->xpath('//cfdi:Concepto') as $cfdiConcepto){ 
        $arreglo14[$i]=array("DESCRIPCION"=>$cfdiConcepto['descripcion']==""?$cfdiConcepto['Descripcion']:$cfdiConcepto['descripcion']);
        $arreglo15[$i]=array("VAL_UNI"=>$cfdiConcepto['valorUnitario']==""?$cfdiConcepto['ValorUnitario']:$cfdiConcepto['valorUnitario']);
             
        $rfc = implode($arreglo2[$x]);
           
        if(!empty($arreglo3[$x]))
        {
           $nombre = implode($arreglo3[$x]);
        }else
        {
          $nombre = "";
        }

        if(!empty($arreglo4[$x]))
        {
          $calle = implode($arreglo4[$x]); 
        }else
        {
          $calle = "";
        }

        if(!empty($arreglo5[$x]))
        {
          $numero = implode($arreglo5[$x]);
        }else
        {
          $numero = "";
        }

        if(!empty($arreglo6[$x]))
        {
          $cp = implode($arreglo6[$x]);
        }else
        {
          $cp = "";
        }

        if(!empty($arreglo7[$x]))
        {
          $pob_col = implode($arreglo7[$x]);
        }else
        {
          $pob_col = "";
        }

        if(!empty($arreglo8[$x]))
        {
          $dis_mun = implode($arreglo8[$x]); 
        }else
        {
          $dis_mun = "";
        }

        if(!empty($arreglo9[$x]))
        {
          $pais = implode($arreglo9[$x]);
        }else
        {
          $pais = "";
        }

        if(!empty($arreglo10[$x]))
        {
          $estado = implode($arreglo10[$x]);
        }else
        {
          $estado = "";
        }

        if(!empty($arreglo11[$x]))
        {
          $localidad = implode($arreglo11[$x]);
        }else
        {
          $localidad = "";
        }
        
        if(!empty($arreglo12[$x]) or !empty($arreglo13[$x]))
        {
          if(implode($arreglo12[$x]) <> "")
          {
            $met_pago = implode($arreglo12[$x]);
          }

          if( implode($arreglo13[$x]) <> "")
          {
            $met_pago = implode($arreglo13[$x]);
          } 

          switch ($met_pago) {
            case 'PUE':
                $met_pago = 'Pago en una sola exhibición';
                break;
            case 'PPD':
               $met_pago = 'Pago en parcialidades o diferido';
                break;
            case '01':
                $met_pago = 'Efectivo';
                break;
            case '02':
                $met_pago = 'Cheque';
                break;
            case '03':
                $met_pago = 'Transferencia';
                break;
            case '04':
                $met_pago = 'Tarjetas de crédito';
                break;
            case '05':
                $met_pago = 'Monederos electrónicos';
                break;
            case '06':
                $met_pago = 'Dinero electrónico';
                break;
            case '07':
                $met_pago = 'Tarjeta dígitales';
                break;
            case '08':
                $met_pago = 'Vales de despensa';
                break;
            case '09':
                $met_pago = 'Bienes';
                break;
            case '10':
                $met_pago = 'Servicio';
                break;
            case '11':
                $met_pago = 'Por cuenta de tercero';
                break;
            case '12':
                $met_pago = 'Dación en pago';
                break;
            case '13':
                $met_pago = 'Pago por subrogación';
                break;
            case '14':
                $met_pago = 'Pago por consignación';
                break;
            case '15':
                $met_pago = 'Condonación';
                break;
            case '16':
                $met_pago = 'Cancelación';
                break;
            case '17':
                $met_pago = 'Compensación';
                break;
            case '28':
                $met_pago = 'Tarjeta de débito';
                break;
            case '29':
                $met_pago = 'Tarjeta de servicio';
                break;
            case '98':
                $met_pago = 'NA';
                break;
            case '99':
                $met_pago = 'Otros';
                break;
            default:
              $met_pago = $met_pago ;
            break;
          }
        }
        else
        {
          $met_pago = "Sin Datos";
        }

        if($UUIDX <> "")
        {
          $uuid = substr($UUIDX, -12); 
        }else
        {
          $uuid = "Sin Dato";
        }        
            
        $descripcion = implode($arreglo14[$i]);
        $val_uni = implode($arreglo15[$i]);
        $no_xml = 1;

        $arreglo1[$i]=array("RFC"=>$rfc, "NOMBRE"=>$nombre, "CALLE"=>$calle, "NUMERO"=>$numero, "CP"=>$cp, "POB_COL"=>$pob_col, "DIS_MUN"=>$dis_mun, "PAIS"=>$pais,"ESTADO"=>$estado, "LOCALIDAD"=>$localidad, "MET_PAG"=>$met_pago, "DESCRIPCION"=>$descripcion, "VAL_UNI"=>$val_uni, "NO_XML"=>$no_xml, "UUID"=>$uuid);

        $i++;
      }

        $x++;
    }
    
    foreach (array_chunk($arreglo1,1000) as $T) {
      DB::table('exports')->insert($T);
    }

  }

}
