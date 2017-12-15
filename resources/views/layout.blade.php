<!DOCTYPE html>
@if(request()->cookie('Usuario_ID')==false)
  {{redirect()->to('/')->send()}}
@endif
<html lang="es">

	<head>
		<title>Grupo Sánchez</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="Sistema Grupo Sanchez" />
		<meta content="" name="Grupo Sanchez" />

		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />

		<link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/themify-icons/themify-icons.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/flag-icon-css/css/flag-icon.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/animate.css/animate.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/switchery/dist/switchery.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/ladda/dist/ladda-themeless.min.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/slick.js/slick/slick.css')}}">
		<link rel="stylesheet" href="{{asset('bower_components/slick.js/slick/slick-theme.css')}}">
    	<link rel="stylesheet" href="{{asset('bower_components/DataTables/media/css/dataTables.bootstrap.min.css')}}">
    	<link rel="stylesheet" type="text/css" href="{{asset('bower_components/FileInput/css/demo.css')}}" />
    	<link rel="stylesheet" type="text/css" href="{{asset('bower_components/FileInput/css/component.css')}}" />

		<link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/plugins.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/themes/lyt5-theme-5.css')}}" >
		<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
		<script src="{{asset('js/sweetalert2.min.js')}}"></script>
		<link href="{{asset('css/app_2.min.css')}}" rel="stylesheet">

		<link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
	</head>

	<body>
		<div id="app" class="lyt-5">
			<!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
				<div class="sidebar-container perfect-scrollbar">
					<div>
						<!-- start: SEARCH FORM -->
						<div class="search-form hidden-md hidden-lg">
							<a class="s-open" href="#"> <i class="ti-search"></i> </a>
							<form class="navbar-form" role="search">
								<a class="s-remove" href="#" target=".navbar-form"> <i class="ti-close"></i> </a>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Numero de guía...">
									<button class="btn search-button" type="submit">
										<i class="ti-search"></i>
									</button>
								</div>
							</form>
						</div>
						<!-- end: SEARCH FORM -->
						<!-- start: USER OPTIONS -->
						<div class="nav-user-wrapper">
							<div class="media">
								<div class="media-left">
									<a class="profile-card-photo" href="#"><img alt="" src="{{asset('assets/images/avatar-1.jpg')}}"></a>
								</div>
								<div class="media-body">
									<span class="media-heading text-white"> {{ request()->cookie('Nombre') }}</span>
									<div class="text-small text-white-transparent">
										 {{ request()->cookie('Nom_Depto') }}<BR>
									</div>
								</div>
								<div class="media-right media-middle">
									<div class="dropdown">
										<button href class="btn btn-transparent text-white dropdown-toggle" data-toggle="dropdown">
											<i class="fa fa-caret-down"></i>
										</button>
										<ul class="dropdown-menu animated fadeInRight pull-right">
											
											<li class="divider"></li>
											<li>
												<a href="/LogOut"> Salir </a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<nav>
							
							<div class="navbar-title">
								<span>Menú Principal</span>
							</div>

              				 @yield('MenuPrincipal')

						</nav>
					</div>
				</div>
			</div>
			<!-- / sidebar -->
			<div class="app-content">
				<!-- start: TOP NAVBAR -->
				<header class="navbar navbar-default navbar-static-top">
					<!-- start: NAVBAR HEADER -->
					<div class="navbar-header">
						<button href="#" class="sidebar-mobile-toggler pull-left btn no-radius hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
							<i class="fa fa-bars"></i>
						</button>
						<a class="navbar-brand" href="/"> <img src="{{asset('assets/images/logo.png')}}" alt="Packet"/> </a>
						<a class="navbar-brand navbar-brand-collapsed" href="/"> <img src="{{asset('assets/images/logo-collapsed.png')}}" alt="" /> </a>

						<button class="btn pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse" data-toggle-class="menu-open">
							<i class="fa fa-folder closed-icon"></i><i class="fa fa-folder-open open-icon"></i><small><i class="fa fa-caret-down margin-left-5"></i></small>
						</button>
					</div>
					<!-- end: NAVBAR HEADER -->
					<!-- start: NAVBAR COLLAPSE -->
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-left hidden-sm hidden-xs">
							<li class="sidebar-toggler-wrapper">
								<div>
									<button href="javascript:void(0)" class="btn sidebar-toggler visible-md visible-lg">
										<i class="fa fa-bars"></i>
									</button>
								</div>
							</li>
							<li>
								<a href="#" class="toggle-fullscreen"> <i class="fa fa-expand expand-off"></i><i class="fa fa-compress expand-on"></i></a>
							</li>
							<li>
								<form role="search" class="navbar-form main-search" >
									<div class="form-group">
                    {{csrf_field()}}
										<input type="text"  name="txtGuiaRastreo" id="txtGuiaRastreo" class="form-control">
										<button class="btn search-button" type="reset">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</form>
							</li>
						</ul>
						<ul class="nav navbar-right">
							<!-- start: MESSAGES DROPDOWN -->
							<li class="dropdown">
								<a href class="dropdown-toggle" data-toggle="dropdown"> <span class="badge"> 0 </span> <i class="fa fa-envelope"></i> </a>
								<ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large animated fadeInUpShort">
									<li>
										<span class="dropdown-header"> Mensajes no leídos</span>
									</li>
									<li>
										<div class="drop-down-wrapper ps-container">
											<ul>
												<!--<li class="unread">
													<a href="javascript:;" class="unread">
													<div class="clearfix">
														<div class="thread-image">
															<img src="{{asset('assets/images/avatar-2.jpg')}}" alt="">
														</div>
														<div class="thread-content">
															<span class="author">Nicole Bell</span>
															<span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula...</span>
															<span class="time"> Just Now</span>
														</div>
													</div> </a>
												</li>-->

											</ul>
										</div>
									</li>
									<li class="view-all">
										<a href="#"> Ver todo </a>
									</li>
								</ul>
							</li>
							<!-- end: MESSAGES DROPDOWN -->
							<!-- start: ACTIVITIES DROPDOWN -->
							<li class="dropdown">
								<a href class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell"></i> </a>
								<ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large animated fadeInUpShort">
									<li>
										<span class="dropdown-header"> Notificaciones</span>
									</li>
									<li>
										<div class="drop-down-wrapper ps-container">
											<div class="list-group no-margin">
												<!--
												<a class="media list-group-item" href=""> <img class="img-circle" alt="..." src="{{asset('assets/images/avatar-1.jpg')}}"> <span class="media-body block no-margin"> Use awesome animate.css <small class="block text-grey">10 minutes ago</small> </span> </a>
												<a class="media list-group-item" href=""> <span class="media-body block no-margin"> 1.0 initial released <small class="block text-grey">1 hour ago</small> </span> </a>
												-->
											</div>
										</div>
									</li>
									<li class="view-all">
										<a href="#"> Ver todo </a>
									</li>
								</ul>
							</li>

						</ul>

						<div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<div class="arrow-left"></div>
							<div class="arrow-right"></div>
						</div>
					</div>
					<button class="sidebar-mobile-toggler dropdown-off-sidebar btn hidden-md hidden-lg"  data-toggle-class="app-offsidebar-open" data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">
						&nbsp;
					</button>
					<button class="dropdown-off-sidebar btn hidden-sm hidden-xs" data-toggle-class="app-offsidebar-open" data-toggle-target="#app" data-toggle-click-outside="#off-sidebar">
						&nbsp;
					</button>

				</header>

				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: BREADCRUMB -->
						<div class="breadcrumb-wrapper">
							<h4 class="mainTitle no-margin">@yield('nombreModulo')</h4>
							<ul class="pull-right breadcrumb">
                @yield('Breadcrumb')
							</ul>
						</div>
						<!-- end: BREADCRUMB -->
            @yield('Contenido')
					</div>
				</div>

			</div>


			<footer>
				<div class="footer-inner">
					<div class="pull-left">
						&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> Grupo Sánchez</span>. <span>Todos los derechos reservados</span>
					</div>
					<div class="pull-right">
						<span class="go-top"><i class="ti-angle-up"></i></span>
					</div>
				</div>
			</footer>
			<!-- end: FOOTER -->
			<!-- start: OFF-SIDEBAR -->
			<div id="off-sidebar" class="sidebar">
				<div class="sidebar-wrapper">
					<ul class="nav nav-tabs nav-justified">
						<li class="active">
							<a href="#off-users" aria-controls="off-users" role="tab" data-toggle="tab"> <i class="ti-comments"></i> </a>
						</li>
						<li>
							<a href="#off-favorites" aria-controls="off-favorites" role="tab" data-toggle="tab"> <i class="ti-heart"></i> </a>
						</li>
						<li>
							<a href="#off-settings" aria-controls="off-settings" role="tab" data-toggle="tab"> <i class="ti-settings"></i> </a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="off-users">
							<div id="users" toggleable active-class="chat-open">
								<div class="users-list">
									<div class="sidebar-content perfect-scrollbar">
									<!--
										<h5 class="sidebar-title">On-line</h5>
										<ul class="media-list">
											<li class="media">
												<a data-toggle-class="chat-open" data-toggle-target="#users" href="#"> <i class="fa fa-circle status-online"></i> <img alt="..." src="{{asset('assets/images/avatar-2.jpg')}}" class="media-object">
												<div class="media-body">
													<h4 class="media-heading">Nicole Bell</h4>
													<span> Content Designer </span>
												</div> </a>
											</li>
											<li class="media">
												<a data-toggle-class="chat-open" data-toggle-target="#users" href="#">
												<div class="user-label">
													<span class="label label-success">3</span>
												</div> <i class="fa fa-circle status-online"></i> <img alt="..." src="{{asset('assets/images/avatar-3.jpg')}}" class="media-object">
												<div class="media-body">
													<h4 class="media-heading">Steven Thompson</h4>
													<span> Visual Designer </span>
												</div> </a>
											</li>
											<li class="media">
												<a data-toggle-class="chat-open" data-toggle-target="#users" href="#"> <i class="fa fa-circle status-online"></i> <img alt="..." src="{{asset('assets/images/avatar-4.jpg')}}" class="media-object">
												<div class="media-body">
													<h4 class="media-heading">Ella Patterson</h4>
													<span> Web Editor </span>
												</div> </a>
											</li>

										</ul>
										<h5 class="sidebar-title">Off-line</h5>
										<ul class="media-list">
											<li class="media">
												<a data-toggle-class="chat-open" data-toggle-target="#users" href="#"> <img alt="..." src="{{asset('assets/images/avatar-6.jpg')}}" class="media-object">
												<div class="media-body">
													<h4 class="media-heading">Nicole Bell</h4>
													<span> Content Designer </span>
												</div> </a>
											</li>
											<li class="media">
												<a data-toggle-class="chat-open" data-toggle-target="#users" href="#">
												<div class="user-label">
													<span class="label label-success">3</span>
												</div> <img alt="..." src="{{asset('assets/images/avatar-7.jpg')}}" class="media-object">
												<div class="media-body">
													<h4 class="media-heading">Steven Thompson</h4>
													<span> Visual Designer </span>
												</div> </a>
											</li>

											<li class="media">
												<a data-toggle-class="chat-open" data-toggle-target="#users" href="#"> <img alt="..." src="{{asset('assets/images/avatar-5.jpg')}}" class="media-object">
												<div class="media-body">
													<h4 class="media-heading">Kenneth Ross</h4>
													<span> Senior Designer </span>
												</div> </a>
											</li>
										</ul>
									-->
									</div>
								</div>
								<div class="user-chat">
									<div class="chat-content">
										<a class="sidebar-back pull-left" href="#" data-toggle-class="chat-open" data-toggle-target="#users"><i class="ti-angle-left"></i> <span>Back</span></a>
										<div class="sidebar-content perfect-scrollbar">
											<ol class="discussion">
												<li class="messages-date">
													Sunday, Feb 9, 12:58
												</li>
												<li class="self">
													<div class="message">
														<div class="message-name">
															Peter Clark
														</div>
														<div class="message-text">
															Hi, Nicole
														</div>
														<div class="message-avatar">
															<img src="{{asset('assets/images/avatar-1.jpg')}}" alt="">
														</div>
													</div>
													<div class="message">
														<div class="message-name">
															Nicole Bell
														</div>
														<div class="message-text">
															How are you?
														</div>
														<div class="message-avatar">
															<img src="{{asset('assets/images/avatar-1.jpg')}}" alt="">
														</div>
													</div>
												</li>

												<li class="messages-date">
													Sunday, Feb 9, 13:10
												</li>
												<li class="other">
													<div class="message">
														<div class="message-name">
															Nicole Bell
														</div>
														<div class="message-text">
															What do you think about my new Dashboard?
														</div>
														<div class="message-avatar">
															<img src="{{asset('assets/images/avatar-2.jpg')}}" alt="">
														</div>
													</div>
												</li>
												<li class="messages-date">
													Sunday, Feb 9, 15:28
												</li>

											</ol>
										</div>
									</div>
									<div class="message-bar">
										<div class="message-inner">
											<a class="link icon-only" href="#"><i class="fa fa-camera"></i></a>
											<div class="message-area">
												<textarea placeholder="Message"></textarea>
											</div>
											<a class="link" href="#"> Send </a>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div role="tabpanel" class="tab-pane" id="off-favorites">
							<div class="users-list">
								<div class="sidebar-content perfect-scrollbar">
								<!--
									<h5 class="sidebar-title">Favorites</h5>
									<ul class="media-list">

										<li class="media">
											<a href="#"> <img alt="..." src="{{asset('assets/images/avatar-4.jpg')}}" class="media-object">
											<div class="media-body">
												<h4 class="media-heading">Ella Patterson</h4>
												<span> Web Editor </span>
											</div> </a>
										</li>

									</ul>
								-->
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="off-settings">
							<div class="sidebar-content perfect-scrollbar">
							<!--
								<h5 class="sidebar-title">General Settings</h5>
								<ul class="media-list">
									<li class="media">
										<div class="padding-10">
											<div class="display-table-cell">
												<input type="checkbox" class="js-switch" checked />
											</div>
											<span class="display-table-cell vertical-align-middle padding-left-10">Enable Notifications</span>
										</div>
									</li>
									<li class="media">
										<div class="padding-10">
											<div class="display-table-cell">
												<input type="checkbox" class="js-switch" />
											</div>
											<span class="display-table-cell vertical-align-middle padding-left-10">Show your E-mail</span>
										</div>
									</li>
									<li class="media">
										<div class="padding-10">
											<div class="display-table-cell">
												<input type="checkbox" class="js-switch" checked />
											</div>
											<span class="display-table-cell vertical-align-middle padding-left-10">Show Offline Users</span>
										</div>
									</li>
									<li class="media">
										<div class="padding-10">
											<div class="display-table-cell">
												<input type="checkbox" class="js-switch" checked />
											</div>
											<span class="display-table-cell vertical-align-middle padding-left-10">E-mail Alerts</span>
										</div>
									</li>
									<li class="media">
										<div class="padding-10">
											<div class="display-table-cell">
												<input type="checkbox" class="js-switch" />
											</div>
											<span class="display-table-cell vertical-align-middle padding-left-10">SMS Alerts</span>
										</div>
									</li>
								</ul>
								<div class="save-options">
									<button class="btn btn-success">
										<i class="icon-settings"></i><span>Save Changes</span>
									</button>
								</div>
							-->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end: OFF-SIDEBAR -->

		</div>

		<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
		<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('bower_components/components-modernizr/modernizr.js')}}"></script>
		<script src="{{asset('bower_components/js-cookie/src/js.cookie.js')}}"></script>
		<script src="{{asset('bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')}}"></script>
		<script src="{{asset('bower_components/jquery-fullscreen/jquery.fullscreen-min.js')}}"></script>
		<script src="{{asset('bower_components/switchery/dist/switchery.min.js')}}"></script>
		<script src="{{asset('bower_components/jquery.knobe/dist/jquery.knob.min.js')}}"></script>
		<script src="{{asset('bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js')}}"></script>
		<script src="{{asset('bower_components/slick.js/slick/slick.min.js')}}"></script>
		<script src="{{asset('bower_components/jquery-numerator/jquery-numerator.js')}}"></script>
		<script src="{{asset('bower_components/ladda/dist/spin.min.js')}}"></script>
		<script src="{{asset('bower_components/ladda/dist/ladda.min.js')}}"></script>
		<script src="{{asset('bower_components/ladda/dist/ladda.jquery.min.js')}}"></script>

		<script src="{{asset('assets/js/letter-icons.js')}}"></script>
		<script src="{{asset('assets/js/main.js')}}"></script>

    	@yield('customScript')
	
	</body>
</html>
