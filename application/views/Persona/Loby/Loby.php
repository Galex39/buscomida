<!DOCTYPE html>
<html lang="es">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>BusCOmida</title>
	<link rel="icon" type="image/png" href="<?= base_url('assets/img/fast-food.png') ?>" />

	<!-- Custom fonts for this template-->
	<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
	<!-- My css -->
	<link href="<?= base_url('assets/css/my_css.css') ?>" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('assets/css/loader.css') ?>">
	<link href="<?= base_url('assets/css/starrr.css') ?>" rel=stylesheet />

</head>

<body id="page-top">
	<!--Id usuario logueado-->
	<input type="hidden" id="id_us" name="id_us"
		value="<?=$this->session->userdata('buscomida_session')['codigo_us']?>">
	<input type="hidden" id="id_mun" name="id_mun"
		value="<?=$this->session->userdata('buscomida_session')['municipio']?>">
	<input type="hidden" id="state_us" name="state_us"
		value="<?=$this->session->userdata('buscomida_session')['estado']?>">
	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<!--Se carga el menu de la persona-->
		<?= $menu ?>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">
				<!-- Se carga la barra de navegacion superior -->
				<?= $nav ?>
				<!-- Begin Page Content -->
				<div class="container-fluid">
					<!-------------------------------------------------------------------------------- Portfolio Grid ------------------------------------------------------------------------------>
					<section class="bg-light page-section" id="portfolio">
						<div class="container">
							<div class="row">
								<div class="col-lg-12 text-center">
									<h2 class="section-heading text-uppercase">¿Qué hay para comer hoy?</h2>
									<h3 class="section-subheading text-muted">¡Toda la comida a un solo click!</h3>
									<a class="nav-link" href="<?= base_url('index.php/Admin/loby/loby') ?>">
									</a>
								</div>
							</div>
							<div class="row" id="panel_pub">
								<!--Aqui se imprimen las publicaciones con jQuery-->

							</div>
							<!--Barra de paginación-->
							<div class="pagUbication">
								<nav aria-label="Page navigation example">
									<ul class="pagination justify-content-center">
									</ul>
								</nav>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Main Content -->

	<!-- Footer -->
	<?= $footer ?>
	<!-- End of Footer -->

	<!-- Scroll to Top Button-->
	<!-- <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a> -->

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">¿Estás listo para irte?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Selecciona "Cerrar sesión" Si estás listo para salir de la aplicación.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-info" href="<?= base_url('index.php/Login/login/cerrar_session') ?>">Cerrar</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal publicación -->
	<div class="modal fade " id="moreInformationPub" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
		aria-hidden="true">
		<div class="modal-dialog " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-uppercase" id="titleModalPub"></h5>
					<input type="hidden" value="" id="id_pub" name="id_pub">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="">
						<img class="img-fluid" id="pubImageView" src="#" alt="...">
					</div>
					<div class="card-body">
						<p class="card-text" id="descriptionPub"></p>
						<ul class="list-inline">
							<li id="fechaInicioPub"></li>
							<li id="horaCadPub"></li>
							<li id="nameDonantePub"></li>
							<li id="telefonoUsPub"></li>
							<li id="direccionPub"></li>
						</ul>
					</div>
					<div class="modal-footer">
						<div class="col-md-8">
							<button type="button" class="btn btn-warning" id="btn-reportar">Reportar Publicación</button>
						</div>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-info" data-dismiss="modal"
							id="btn-recivir">Recibir</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal publicacion nueva -->
	<div class="modal fade newpub" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog modal-xl " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title " id="exampleModalLongTitle">NUEVA DONACIÓN</h1>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<form role="form" id="newpub_form" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="row" style="margin: 1%">
							<div class="col-lg-4" style="margin-top: 2%">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title card-text-pipe text-uppercase">Foto del Alimento
										</h3>
									</div>
									<!-- form start -->
									<div class="card-body">
										<div class="form-group" style="font-size: 24px; text-align: center;">
											<img src="<?= base_url('assets/files/publicaciones/default_pub.jpg') ?>" class="preImPub" alt="" style="width: 100%; height: 270px" id="preImagePub">
										</div>
										<div class="form-group">
											<div class="input-group">
												<div class="custom-file">
													<input type="file" class="custom-file-input formPubInput" id="imagenPub" name="imagen"
														required>
													<label class="custom-file-label " for="exampleInputFile">Elige tu
														foto</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-8" style="margin-top: 2%">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title card-text-pipe text-uppercase">Donaciones</h3>
									</div>
									<!-- form start -->
									<div class="card-body">
										<div class="form-group">
											<input type="hidden" name="municipio"
												value="<?=$this->session->userdata('buscomida_session')['municipio']?>">
											<input type="hidden" class="form-control" id="id_us_np" name="id_us"
												value="<?=$this->session->userdata('buscomida_session')['codigo_us']?>">
										</div>
										<div class="form-group">
											<label for="titulo">Nombre del alimento</label>
											<input type="text" class="form-control formPubInput" id="titulo" name="titulo"
												placeholder="Ej: Arroz paisa" required>
										</div>
										<div class="form-group">
											<label for="descripcion">Descripción del alimento</label>
											<input type="text" class="form-control formPubInput" id="descripcion" name="descripcion"
												placeholder="Ej: Media caja de arroz paisa con papas a la francesa" required>
										</div>
										<div class="form-group">
											<label for="...">Ubicación del Alimento</label>
											<input type="text" class="form-control formPubInput" id="ubicacion" name="ubicacion"
												placeholder="Ej: Calle 21 # 18 - 02 esquina" required>
										</div>
										<div class="form-row">
											<div class="form-group col-md-12">
												<label for="inputState">Tiempo de duración</label>
												<select class="form-control formPubInput" name="tiempo" id="inputZip">
													<option value="" selected disabled>Tiempo disponible</option>
													<option value="30">30 minutos</option>
													<option value="60">1 hora</option>
													<option value="90">1 hora y 30 minutos</option>
													<option value="120">2 horas</option>
													<option value="150">2 horas y 30 minutos</option>
													<option value="180">3 horas</option>
													<option value="310">3 horas y 30 minutos</option>
													<option value="340">4 horas</option>
													<option value="0">Indefinido</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<button type="button" id="btn-publicar" class="btn btn-info">Publicar</button>
						</div>
					</div>
				</form>
				<div class="load-container" id="waitInsertPub">
					<div class="preloader"></div>
				</div>
			</div>
		</div>
	</div>

	<!--Modal confirmar entregado-->
	<div class="modal fade" id="confEnt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Info remitente</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body row" id="putInfo">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" id="btn-entregado" class="btn btn-info"
						data-dismiss="modal">Entregado</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

	<!-- jQuery libaries -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

	<!-- Custom scripts for all pages-->
	<script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

	<!-- My jQuery code -->
	<script src="<?= base_url('assets/js/starrr.js') ?>"></script>
	<script src="<?= base_url('assets/js/publicaciones.js') ?>"></script>

</body>

</html>
