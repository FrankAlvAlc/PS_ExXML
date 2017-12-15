<?php

function DebugOut($Archivo, $String){
	$F=fopen($Archivo,"w");
	fwrite($F,$String);
	fclose($F);
}

function randomPassword($Tam){
$caracteres = "JB3wbOCF7eT9Pu4cYqj1xNyzX0r6Z8oEAgSHaQRvVh2MfdWk5nGDstlmIiUKLp";
		$cadena = ""; //variable para almacenar la cadena generada
		for($i=1;$i<$Tam;$i++)
		{
		 $cadena .= substr($caracteres,rand(0,63),1); /*Extraemos 1 caracter de los caracteres
		entre el rango 0 a Numero de letras que tiene la cadena */
		}
		return $cadena;
}

/*=======================================================================*/

function encrypt1($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

/*=======================================================================*/

function decrypt1($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}

/*=======================================================================*/

function TransformaFecha($Fecha){
	$datetime = $Fecha; //01/12/2016
	$dd = substr($datetime,0,2);
	$mm = substr($datetime,3,2);
	$yyyy = substr($datetime,6,9);
	return $yyyy.'-'.$mm.'-'.$dd;
}
/*=======================================================================*/
function FormateaFecha($Fecha){
			$Fecha="{ts'".$Fecha." 00:00:00'}";
			return $Fecha;
	}
/*=======================================================================*/
function FechaMSSQL(){
			date_default_timezone_set('America/Mexico_City');
			$Fecha="{ts'".date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s')."'}";
			return $Fecha;
	}
/*=======================================================================*/

function QuotedLike($String){
	$String=(QuitarEspacios($String));
	$QuotedString="'%".$String."%'";
	return $QuotedString;
	}

/*=======================================================================*/
function QuotedStr($String){
	$String=(QuitarEspacios($String));
	$QuotedString="'".$String."'";
	return $QuotedString;
	}
/*=======================================================================*/
function QuitarEspacios($Original){
	$Original=trim($Original);
	$Ncaract=strlen($Original);
	$Flag=0;
	$NCadena='';

	for($x=0;$x<$Ncaract;$x++){
			if ($Flag==0){
				$NCadena=$NCadena.$Original[$x];
				}else{
						if ($Original[$x]!=' '){//if 2
							$NCadena=$NCadena.$Original[$x];
							}//If 2
					}

			if($Original[$x]==' '){
				$Flag=1;
				}else{
					$Flag=0;
					}
		}
		$NCadena=utf8_decode($NCadena);
		return $NCadena;

	}	//End function QuitarEspacios
/*=======================================================================*/
function CorregirRFC($RFC){
	$NRFC='';
	$RFC=trim($RFC);
	$Num=strlen($RFC);
for($x=0;$x<$Num;$x++){
	if ($RFC[$x]!='-'&&$RFC[$x]!=' '){
		$NRFC=$NRFC.$RFC[$x];
		}
	}

	return $NRFC;

	}
/*=======================================================================*/
function EvaluaFecha($Year,$Month,$Day){
	//Esta funcion es valida para saber si una fecha introducida es valida
			//Meses con 31 dias: 01,03,05,07,08,10,12
		//Meses con 30 dias:04,06,09,11
		//Meses con al menos 29 dias:02
	$Respuesta='Sin Dato';
	if (is_numeric($Year)){
		 if($Year>=0 && $Year<=99){
             if(is_numeric($Month)){
                 if($Month>=1 && $Month<=12){
                     if(is_numeric($Day)){
                         if ($Day>31){
                             $Respuesta='Dia Incorrecto';
                         }
                         else
                         {
                             if($Month==2&&$Day>29){
                                 $Respuesta='Febrero solo tiene hasta 29 dias';
                             }else{
                                 if($Month==4&&$Day>30 || $Month==6 && $Day>30 || $Month==9&&$Day>30 ||$Month==11 &&$Day>30){
                                     $Respuesta='Este mes solo tiene 30 dias';
                                 }else{
                                     $Respuesta='OK';
                                 }
                             }//
                         }
                     }else{
                         $Respuesta='Formato Incorrecto: Día';
                     }
                 }
                 else {
                     $Respuesta = 'Formato Incorrecto: Mes';
                 }
             }
			 }
		}
		else
		{
		  $Respuesta='Formato incorrecto:Año';
		}


return $Respuesta;
}

/*=======================================================================*/
function validaRFC($RFC){

	// Validar Longitud de RFC

	$RFC=trim($RFC);
	$Long=strlen($RFC);
	if ($Long>13){
		$Respuesta='RFC Invalido: Contiene más de 13 Caracteres';
		}
		else{
			if ($Long<12){
				$Respuesta='RFC Invalido: Dato incompleto, debe contener al menos 12 Caracteres';
				}
		     }

	//Decomponer RFC segun la longitud
	switch($Long){
		case 13:
			$Principal=substr($RFC,0,4);
			$Fecha=substr($RFC,4,6);
			$HomoClave=substr($RFC,10,3);
			//Validar los primeros 4 caracteres sean letras
			for($x=0;$x<=3;$x++){
				$Evalua=substr($Principal,$x,1);
				if(is_numeric($Evalua)){
					$Fase1='RFC Invalido: Caracter no permitido en Principal(Posicion:'.$x.' - Valor:'.$Evalua.')';
					break;
					}
					$Fase1='Fase 1: OK';
				}
			//Agrupar la fecha en grupos de 2 y validar se encuentre dentro de los valores permitidos
			$Fase2=EvaluaFecha(substr($Fecha,0,2),substr($Fecha,2,2),substr($Fecha,4,2));
			$Resultado='Fase1('.$Fase1.'),Fase2('.$Fase2.')';
			$Respuesta=$Resultado;
		break;
		case 12:
			$Principal=substr($RFC,0,3);
			$Fecha=substr($RFC,3,6);
			$HomoClave=substr($RFC,9,3);
			//Validar los primeros 3 Caracteres que sean letras
			for($x=0;$x<=2;$x++){
				$Evalua=substr($Principal,$x,1);
				if(is_numeric($Evalua)){
					$Fase1='RFC Invalido: Caracter no permitido en Principal(Posicion:'.$x.' - Valor:'.$Evalua.')';
					break;
					}
					$Fase1='OK';
				}
			//Agrupar la fecha en grupos de 2 y validar se encuentre dentro de los valores permitidos
			$Fase2=EvaluaFecha(substr($Fecha,0,2),substr($Fecha,2,2),substr($Fecha,4,2));
			$Resultado='Fase1('.$Fase1.'),Fase2('.$Fase2.')';
			$Respuesta=$Resultado;
		break;
		}

	return($Respuesta);
	}
/*===================================================================*/
 function bases($base,$NombreTaller,$Valores){
	 if ($base==1){
		  $base1="{
          name: '".$NombreTaller."',
          type: 'bar',
          data: [".$Valores."],
          markPoint: {
            data: [{
              type: 'max',
              name: '???'
            }, {
              type: 'min',
              name: '???'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: '???'
            }]
          }
        }";
		$Bases=$base1;
	 }else{
		$base2="{
          name: '".$NombreTaller."',
          type: 'bar',
          data: [".$Valores."],
          markPoint: {
            data: [{
              type: 'max',
              name: '???'
            }, {
              type: 'min',
              name: '???'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: '???'
            }]
          }}";
		  $Bases=$base2;
		}
		  return $Bases;
	}
	/*=================================================================*/

	function obtenerFechaEnLetra($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $dia.', '.$num.' de '.$mes.' del '.$anno;
}

/*=================================================================*/

function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}

/*=================================================================*/

function TruncarString($string, $limit, $break=".", $pad="...")
{
  if(strlen($string) <= $limit) return $string;

  $string = substr($string, 0, $limit);
  if(false !== ($breakpoint = strrpos($string, $break))) {
    $string = substr($string, 0, $breakpoint);
  }

  return $string . $pad;
}

?>
