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
					<h5 class="over-title margin-bottom-15">Carga de <span class="text-bold">CFDI's</span></h5>
					<p>
						Seleccione los archivos que desea renombrar
					</p>

					<form method="post" enctype="multipart/form-data" action="/CFDI/Cargar">
					{{ csrf_field() }}
					<div class="box">
						<input type="file" name="file-1[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} Archivos Seleccionados" multiple accept="application/pdf,text/xml" />
						<label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Seleccione Archivos&hellip;</span></label>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label> Nombre para el paquete de archivos <span class="symbol required"></span> </label>
								<div class="form-group">
									<input type="text" placeholder="Nombre del paquete" name="txtPaquete" onkeypress="return soloLetras(event,'txtPaquete',50);" id="txtPaquete" class="form-control">
								</div>
							</div>
						</div>
					</div>
					<input type="submit" class="btn btn-info" value="Validar">
  				</form>

					<br><br>
					@if (Session::has('punto'))
								 <div class="alert alert-danger">
									 <strong>{{ Session::get('punto') }}</strong>
								 </div>
								 @elseif(session::has('xml'))
									 <div class="alert alert-warning">
										 <strong>{{ Session::get('xml') }}</strong>
									 </div>
									 @elseif(session::has('pdf'))
										<div class="alert alert-warning">
											<strong>{{ Session::get('pdf') }}</strong>
										</div>
									@elseif(session::has('archivo_vacio'))
										<div class="alert alert-warning">
											<strong>{{ Session::get('archivo_vacio') }}</strong>
										</div>
									@elseif(session::has('carga'))
										<div class="alert alert-warning">
											<strong>{{ Session::get('carga') }}</strong>
										</div>
								 @endif


        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('customScript')
<script src="{{asset('js/validaForms.js')}}"></script>
<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
<script src="{{asset('bower_components/FileInput/js/custom-file-input.js')}}"></script>

<script>
  jQuery(document).ready(function(){
    Main.init();

  });
</script>
@stop
