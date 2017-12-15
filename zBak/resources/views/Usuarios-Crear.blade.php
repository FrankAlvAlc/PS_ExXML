@extends('layout')

@section('MenuPrincipal')
	@php
	  echo $MenuPrincipal
	@endphp
@stop

@section('Breadcrumb')
<li>
  <a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Usuarios</a>
</li>
<li>
  Crear
</li>
@stop


@section('Contenido')
<div class="container-fluid container-fullw">
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-white">
										<div class="panel-body">

														<div>
															<div class="center">

																<div class="fileinput fileinput-new" data-provides="fileinput">
																	<div class="user-image">
																		<div class="fileinput-new thumbnail" style="cursor:pointer;" data-toggle="modal" data-target=".bs-example-modal-lg">
																		  <img src="{{asset('assets/images/avatar-1-xl.jpg')}}" alt="">
																		</div>
																	</div>
																</div>
                                {{csrf_field()}}
                                <input type="hidden" name="txtStringDat" id="txtStringDat" value="0" />
																<hr>
																<div class="social-icons block" id="dNombreColab">
																	<h3>... ... ...</h3>
																</div>
																<hr>
                                <div class="row">
																<div class="col-md-4 col-sm-push-2">
																<div class="form-group">
																	<label>Nombre usuario<span class="symbol required"></span> </label>
																	<input type="text" placeholder="Nombre de usuario para acceso al sistema" class="form-control" name="txtUName" id="txtUName"/>
																</div>
															</div>

                              <div class="col-md-4 col-sm-push-2">
                              <div class="form-group">
                                <label>Correo Electrónico<span class="symbol required"></span> </label>
                                <input type="text" placeholder="Correo Electrónico" class="form-control" name="txtMail" id="txtMail"/>
                              </div>
                              </div>
                              </div>

                              <div class="row">
                              <div class="col-md-4 col-sm-push-2">
                              <div class="form-group">
                                <label>Teléfono o Extensión </label>
                                <input type="text" placeholder="000 000 00 00" class="form-control" name="txtTelefono" id="txtTelefono"/>
                              </div>

                              </div>

															</div>

															<div class="col-sm-2 col-sm-push-5"><button class="btn btn-primary btn-o CrearUsuario">Crear Usuario</button></div>
															</div>
                              <div id="DatosColab">
															<table class="table table-condensed">
																<thead>
																	<tr>
																		<th colspan="2">Información General</th>
																	</tr>
																</thead>
																<tbody>
                                  <tr>
																		<td>Empresa</td>
																		<td id="dEmpresa"></td>
																	</tr>
																	<tr>
																		<td>Departamento</td>
																		<td id="dDepartamento"></td>
																	</tr>
																	<tr>
																		<td>Puesto</td>
																		<td id="dPuesto"></td>
																	</tr>
																</tbody>
															</table>
                            </div>
														</div>

												<div class="modal fade bs-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
																<h4 class="modal-title" id="myModalLabel">Catalogo de colaboradores</h4>
															</div>
															<div class="modal-body">
                                <div class="row">
												          <div class="col-md-6">
        														<div class="form-group">
        															<label> Buscar <span class="symbol required"></span> </label>
        															<div class="form-group">
        																<input type="text" onkeypress="ListaColab(this.value);" placeholder="Escribe el nombre del colaborador" name="txtBUsuarios" id="txtBUsuarios" class="form-control underline">
        															</div>
        														</div>
                               </div>
      												<div class="col-sm-12" id="ListaColab" style="min-height:350px;max-height">

      												</div>
											        </div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
																	Cerrar
																</button>

															</div>
														</div>
													</div>
												</div>

					</div>
        </div>
			</div>			</div>
    			</div>
@stop


@section('customScript')
<script src="{{asset('assets/js/selectFx/classie.js')}}"></script>
<script src="{{asset('assets/js/selectFx/selectFx.js')}}"></script>

<script src="{{asset('bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('bower_components/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/table-data.js')}}"></script>


<script src="{{asset('js/Usuarios.js')}}"></script>


<script>
 jQuery(document).ready(function(){
  Main.init();
  TableData.init();

  });
</script>


@stop
