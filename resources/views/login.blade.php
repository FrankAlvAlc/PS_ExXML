<!DOCTYPE html>
<html lang="es-MX">

	<head>
		<title>Grupo Sánchez | Iniciar Sesión</title>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="Aplicación desarrollada para el departamento de trafico de la empresa" />
		<meta content="" name="Grupo Sanchez" />



		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- end: GOOGLE FONTS -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="{{asset('/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/themify-icons/themify-icons.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/flag-icon-css/css/flag-icon.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/animate.css/animate.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/switchery/dist/switchery.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/ladda/dist/ladda-themeless.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/slick.js/slick/slick.css') }}">
		<link rel="stylesheet" href="{{ asset('/bower_components/slick.js/slick/slick-theme.css') }}">
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: Packet CSS -->
		<link rel="stylesheet" href="{{ asset('/assets/css/styles.css') }}">
		<link rel="stylesheet" href="{{ asset('/assets/css/plugins.css') }}">
		<link rel="stylesheet" href="{{ asset('/assets/css/themes/lyt1-theme-1.css') }}" >

		<link rel="stylesheet" href="{{ asset('/css/sweetalert2.min.css') }}">
		<script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
		<link href="{{ asset('/css/app_2.min.css') }}" rel="stylesheet">

		<link rel="shortcut icon" href="{{asset('favicon.ico')}}" />

	</head>

	<body class="login">

		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">
				<div class="logo text-center">
					<img src="{{asset('assets/images/logo-big.png')}}"  class="img-responsive" />
				</div>
				<p class="text-center text-dark text-bold text-extra-large margin-top-15">

					Bienvenido
				</p>
				@if(isset($UName))
					 <div class="alert alert-danger">
						 {{ session()->get('UName') }}
					 </div>
				@endif
				<p class="text-center">
					Por favor, introduzca su nombre de usuario y contraseña para iniciar sesión.
				</p>
        {{csrf_field()}}
				<div class="box-login">
					<?php
					$Clase='';
					?>
					<form class="form-login"  method="post" name="formLogin" id="formLogin" action="/Login">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group error">
							<input type="text" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="Usuario">
						</div>
						<div class="form-group form-actions">

							<input type="password" class="form-control password" name="txtPwd" id="txtPwd" placeholder="Contraseña">

						</div>
						<div class="text-center">
							<a href="/"> Olvide mi contraseña </a>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-red btn-block ">
								Entrar
							</button>

						</div>
						
					</form>

					<div class="copyright">
						2017 &copy; Grupo Sánchez.
					</div>

				</div>

			</div>
		</div>

		<script src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>
		<script src="{{ asset('/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('/bower_components/components-modernizr/modernizr.js') }}"></script>
		<script src="{{ asset('/bower_components/js-cookie/src/js.cookie.js') }}"></script>
		<script src="{{ asset('/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}"></script>
		<script src="{{ asset('/bower_components/jquery-fullscreen/jquery.fullscreen-min.js') }}"></script>
		<script src="{{ asset('/bower_components/switchery/dist/switchery.min.js') }}"></script>
		<script src="{{ asset('/bower_components/jquery.knobe/dist/jquery.knob.min.js') }}"></script>
		<script src="{{ asset('/bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') }}"></script>
		<script src="{{ asset('/bower_components/slick.js/slick/slick.min.js') }}"></script>
		<script src="{{ asset('/bower_components/jquery-numerator/jquery-numerator.js') }}"></script>
		<script src="{{ asset('/bower_components/ladda/dist/spin.min.js') }}"></script>
		<script src="{{ asset('/bower_components/ladda/dist/ladda.min.js') }}"></script>
		<script src="{{ asset('/bower_components/ladda/dist/ladda.jquery.min.js') }}"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="{{ asset('/bower_components/ckeditor/ckeditor.js') }}"></script>
		<script src="{{ asset('/bower_components/ckeditor/adapters/jquery.js') }}"></script>
		<script src="{{ asset('/bower_components/bb-jquery-validation/dist/jquery.validate.js') }}"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: Packet JAVASCRIPTS -->
		<script src="{{ asset('/assets/js/letter-icons.js') }}"></script>
		<script src="{{ asset('/assets/js/main.js') }}"></script>
		<!-- end: Packet JAVASCRIPTS -->
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="{{ asset('/assets/js/login.js') }}"></script>

		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});

		</script>
	</body>
</html>
