@extends('layout')

@section('MenuPrincipal')
	@php
	  echo $MenuPrincipal
	@endphp
@stop

@section('Contenido')
	<div class="container-fluid container-fullw">
  		<div class="row">
    		<div class="col-md-12">
      			<div class="panel panel-white">
        			<div class="panel-body">
						<h5 class="over-title margin-bottom-15">Extractor de <span class="text-bold">XML</span></h5>
						<p>
							Escribir Ubicación XML
						</p>

						@if ($errors->any())
	                        <div class="alert alert-danger">
	                            <ul>
	                                @foreach ($errors->all() as $error)
	                                    <li>{{ $error }}</li>
	                                @endforeach
	                            </ul>
	                        </div>
	                    @endif

	                    @if (session()->has('msj'))
	                    	@if(session('msj') == '0')
		                    	<div class="alert alert-danger" role="alert">Carpeta no encontrada.</div>
	                    	@endif
	                    	@if(session('msj') == '1')
		                    	<div class="alert alert-success" role="alert">Archivo generado correctamente.</div>
	                    	@endif
	                    @endif




						<form>
							{{ csrf_field() }}
							<div class="form-group">
								<label>Ruta:</label>
								<input type="text" class="form-control"  id="ruta" name="ruta" placeholder="//Xml/vsg080207hb82/2017/" />
  							</div>
  							
							<input type="button" onclick="ExtraerDatos();" class="btn btn-info" value="Extraer">
							<div id="DataProducto">
  							</div>
  						</form>
  					
  					</div>
      			</div>
    		</div>
  		</div>
	</div>
@stop

@section('customScript')
	<script src="{{asset('js/validaForms.js')}}"></script>
	<script>
		(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);
	</script>

	<script>
		function ExtraerDatos(){
		  //e.preventDefault();
		  var _token = $('input[name="_token"]').val();
		  var ruta = document.getElementById('ruta').value;

		  $.ajax({
		    url:'/CFDI/Cargar',
		    type:'post',
		    data:{_token:_token, ruta:ruta},
		    beforeSend:function(){
		      document.getElementById("DataProducto").innerHTML='<center><h3><img src="http://archivos.lasnoticiasdetulum.com/fotos/plantilla/Cargando.gif" width="100" height="100"/> <br> Procesando Archivos XML</h3></center>';'<i class="fa fa-check" aria-hidden="true"></i>';
		    },
		    success:function(data){

		      swal('Archivo','Archivo generado correctamente','success');
		      document.getElementById("DataProducto").innerHTML='<br /><a class="btn btn-success" name="descargarrr" id="descargarrr" href="/XML_Datos_{{ request()->cookie('Usuario_ID') }}.xlsx" download>Descargar </a>';
		    },
		    error(data){
		      swal('Error interno','Error interno del sistema, intentelo nuevamente o comuniquese con el administrador del sistema','error');
		      document.getElementById("DataProducto").innerHTML='';
		    }
		  });
		}

		
	</script>


	<script src="{{asset('bower_components/FileInput/js/custom-file-input.js')}}"></script>
	<script>
  		jQuery(document).ready(function(){
    		Main.init();
    	});
	</script>
@stop
