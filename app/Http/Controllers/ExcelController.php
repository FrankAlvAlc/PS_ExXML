<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


use App\Http\Requests;
use App\Export;

use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
	public function index()
 	{
 		Excel::create('XML_Datos_'. request()->cookie('Usuario_ID') , function($excel) {

 			$excel->setTitle('Datos de CFDI');
      $excel->setCreator('Grupo Sanchez')->setCompany('Grupo Sanchez');
      $excel->setDescription('Datos de CFDI');

      $excel->sheet('Datos', function($sheet){

 	      $Exports = DB::table('v_datos_cfdi')
          ->select('v_datos_cfdi.*')
          ->get();

        $sheet -> setOrientation('landscape');
        $sheet -> setCellValue('A1', '');
        $sheet -> setCellValue('B1', '');
        $sheet -> setCellValue('C1', '');
        $sheet -> setCellValue('D1', '');
        $sheet -> setCellValue('E1', '');
        $sheet -> setCellValue('F1', '');
        $sheet -> setCellValue('G1', '');
        $sheet -> setCellValue('H1', '');
        $sheet -> setCellValue('I1', '');
        $sheet -> setCellValue('J1', '');
        $sheet -> setCellValue('K1', '');
        $sheet -> setCellValue('L1', '');
        $sheet -> setCellValue('M1', '');
        $sheet -> setCellValue('N1', '');
        $sheet -> setCellValue('O1', '');
        $sheet -> setCellValue('P1', '');
        $sheet -> setCellValue('Q1', '');
        $sheet -> setCellValue('R1', '');
        $sheet -> setCellValue('S1', '');
        $sheet -> setCellValue('T1', '');
        $sheet -> setCellValue('U1', '');
        $sheet -> setCellValue('V1', '');
        $sheet -> setCellValue('W1', '');
        $sheet -> setCellValue('X1', '');
        $sheet -> setCellValue('Y1', '');
        $sheet -> setCellValue('Z1', '');
        
        $x=2;
          $sheet->appendRow(array('RFC EMISOR', 'RFC RECEPTOR', 'NOMBRE EMISOR', 'CODIGO POSTAL', 'POBLACION O COLONIA', 'DISTRITO O MUNICIPIO', 'PAIS', 'ESTADO', 'LOCALIDAD', 'METODO PAGO', 'VERSION CFDI', 'FORMA PAGO', 'USO CFDI', 'REGIMEN FISCAL', 'CLAVE PRODUCTO', 'UNIDAD MEDIDA', 'CLAVE UNIDAD', 'DESCRIPCION', 'VALOR UNITORIO', 'SUBTOTAL', 'IVA', 'ISR RETENIDO', 'IVA RETENIDO', 'UUID', 'FECHA EMISION', 'FECHA CERTIFICACION'));

        foreach ($Exports as $Info)
          {
            $sheet -> setCellValue('A'.$x, $Info->rfc_emisor);
            $sheet -> setCellValue('B'.$x, $Info->rfc_receptor);
            $sheet -> setCellValue('C'.$x, $Info->nombre_emisor);
            $sheet -> setCellValue('D'.$x, $Info->cp);
            $sheet -> setCellValue('E'.$x, $Info->pob_col);
            $sheet -> setCellValue('F'.$x, $Info->dis_mun);
            $sheet -> setCellValue('G'.$x, $Info->pais);
            $sheet -> setCellValue('H'.$x, $Info->estado);
            $sheet -> setCellValue('I'.$x, $Info->localidad);
            $sheet -> setCellValue('J'.$x, $Info->met_pag);
            $sheet -> setCellValue('K'.$x, $Info->version_cfdi);
            $sheet -> setCellValue('L'.$x, $Info->forma_pago);
            $sheet -> setCellValue('M'.$x, $Info->uso_cfdi);
            $sheet -> setCellValue('N'.$x, $Info->regimen_fiscal);
            $sheet -> setCellValue('O'.$x, $Info->clave_producto);
            $sheet -> setCellValue('P'.$x, $Info->unidad_medida);
            $sheet -> setCellValue('Q'.$x, $Info->cve_unidad);
            $sheet -> setCellValue('R'.$x, $Info->descripcion);
            $sheet -> setCellValue('S'.$x, $Info->val_uni);
            $sheet -> setCellValue('T'.$x, $Info->sub_total);
            $sheet -> setCellValue('U'.$x, $Info->iva);
            $sheet -> setCellValue('V'.$x, $Info->isr_retenido);
            $sheet -> setCellValue('W'.$x, $Info->iva_retenido);
            $sheet -> setCellValue('X'.$x, $Info->uuid);
            $sheet -> setCellValue('Y'.$x, $Info->fecha_emision);
            $sheet -> setCellValue('Z'.$x, $Info->fecha_certificacion);

            $x++;
          }
                  
        //$deleted = DB::delete('DELETE FROM exports');   
            	
      });
    })->store('xlsx', storage_path('../public/'));

  }
}
       


        
        
/*

        $sheet->appendRow(array('RFC EMISOR', 'RFC RECEPTOR', 'NOMBRE EMISOR', 'CODIGO POSTAL', 'POBLACION O COLONIA', 'DISTRITO O MUNICIPIO', 'PAIS', 'ESTADO', 'LOCALIDAD', 'METODO PAGO', 'VERSION CFDI', 'FORMA PAGO', 'USO CFDI', 'REGIMEN FISCAL', 'CLAVE PRODUCTO', 'UNIDAD MEDIDA', 'CLAVE UNIDAD', 'DESCRIPCION', 'VALOR UNITORIO', 'SUBTOTAL', 'IVA', 'ISR RETENIDO', 'IVA RETENIDO', 'UUID', 'FECHA EMISION', 'FECHA CERTIFICACION'));
         foreach ($Exports->chunk(1000) as $chunk)
        {
          foreach ($chunk as $row)
          {
            $sheet->appendRow(array(
              $row->rfc_emisor, $row->rfc_receptor, $row->nombre_emisor, $row->cp, $row->pob_col, $row->dis_mun, $row->pais, $row->estado, $row->localidad, $row->met_pag, $row->version_cfdi, $row->forma_pago, $row->uso_cfdi, $row->regimen_fiscal, $row->clave_producto, $row->unidad_medida, $row->cve_unidad, $row->descripcion, $row->val_uni, $row->sub_total, $row->iva,  $row->isr_retenido, $row->iva_retenido, $row->uuid, $row->fecha_emision, $row->fecha_certificacion
            ));
          }
        }*/