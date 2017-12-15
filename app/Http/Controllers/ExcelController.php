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
 		Excel::create('XML_Datos', function($excel) {

            $excel->sheet('Datos', function($sheet) {

 	        	$Exports = Export::select('rfc AS RFC', 'nombre AS NOMBRE', 'calle AS CALLE', 'numero AS NUMERO', 'cp AS CODIGO POSTAL', 'pob_col AS POBLACION O COLONIA', 'dis_mun AS DISTRITO O MUNICIPIO', 'pais AS PAIS', 'estado AS REGION O ESTADO', 'localidad AS LOCALIDAD', 'met_pag AS METODO DE PAGO', 'descripcion AS DESCRIPCION', 'val_uni AS VALOR UNITARIO', DB::raw('SUM(no_xml) AS NOXML'), 'uuid AS UUID' )
 	        	->groupBy('rfc', 'nombre', 'numero', 'calle', 'cp', 'pob_col', 'dis_mun', 'pais', 'estado', 'localidad', 'met_pag', 'descripcion', 'val_uni', 'uuid')
 	        	->get();

            	$sheet->fromArray($Exports);

            	$deleted = DB::delete('DELETE FROM exports');    
            				
        	});
        })->export('xls');

    }
}
