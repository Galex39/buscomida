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
								<h2 class="section-heading text-uppercase">Denuncias</h2>
									<h3 class="section-subheading text-muted">Aquí podrás encontrar todas las publicaciones que fueron denunciadas por los usuarios</h3>
								</div>
							</div>
							<div class="row" id="panel_pub" style="margin-top: 4em">
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
	<a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
	</a>
	
		<!-- MODALS --><!-- MODALS --><!-- MODALS --><!-- MODALS --><!-- MODALS --><!-- MODALS --><!-- MODALS --><!-- MODALS -->
	<!-- modal targeta -->
	<div class="modal fade " id="moreInformationPub" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
		aria-hidden="true">
		<div class="modal-dialog " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-uppercase" id="titleModalPub"></h5>
					<input type="hidden" id="id_pub" name="id_pub">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="">
						<img class="img-fluid imgModal" id="pubImageView" src="#" alt="...">
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
						<button type="button" id="quitarRep" class="btn btn-warning col-md-4">Quitar reporte</button>
						<button type="button" id="deletePub" class="btn btn-success">Eliminar Publicación</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

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
				<div class="modal-body">Selecciona cerrar para salir de la aplicación</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-success" href="<?= base_url('index.php/Login/login/cerrar_session') ?>">Cerrar</a>
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
	<script src="<?= base_url('assets/js/reportes.js') ?>"></script>

</body>

</html>
