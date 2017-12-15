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




						<form method="post" action="/CFDI/Cargar">
							{{ csrf_field() }}
							<div class="form-group">
								<label>Ruta:</label>
								<input type="text" class="form-control"  name="ruta" placeholder="//Xml/vsg080207hb82/2017/" value="{{ old('ruta') }}" >
  							</div>
							<input type="submit" class="btn btn-info" value="Extraer">
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
	<script src="{{asset('bower_components/FileInput/js/custom-file-input.js')}}"></script>
	<script>
  		jQuery(document).ready(function(){
    		Main.init();
    	});
	</script>
@stop
