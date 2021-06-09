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
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
	<!-- My css -->
	<link href="<?= base_url('assets/css/my_css.css') ?>" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('assets/css/loader.css') ?>">

</head>

<body id="page-top">
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
					<div class="row">
						<div class="col-lg-12 text-center">
						<h2 class="section-heading text-uppercase">Estadísticas</h2>
							<h3 class="section-subheading text-muted">Aquí podrás encontrar todas las estadísticas que necesitas</h3>
						</div>
					</div>
					<div class="row" style="margin-top: 3em;">
			            <!-- Area Chart -->
			            <div class="col-xl-8 col-lg-7">
			              <div class="card shadow mb-4">
			                <!-- Card Header - Dropdown -->
			                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			                  <h6 class="col-md-6 col-sm-5 m-0 font-weight-bold text-primary">Publicaciones por mes</h6>
			                  <div class="form-group col-md-4 col-sm-4">
			                  	<input type="numbrer" class="form-control" name="year" id="year" >
			                  </div>
			                  <button type="button" class="btn btn-success col-md-2 col-sm-3" name="btn-year" id="btn-year">Generar</button>
			                </div>
			                <!-- Card Body -->
			                <div class="card-body">
			                  <div class="chart-area">
			                    <canvas id="chartPxM" class="chartjs-render-monitor"></canvas>
			                  </div>
			                </div>
			              </div>
			            </div>
			            <div class="col-xl-4 col-lg-5">
			              <div class="card shadow mb-4">
			                <!-- Card Header - Dropdown -->
			                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			                  <h6 class="col-md-5 m-0 font-weight-bold text-primary">Comparación</h6>
			                  <div class="form-group col-md-4 col-sm-4">
			                  	<input type="numbrer" class="form-control" name="year1" id="year1" >
			                  </div>
			                  <button type="button" class="btn btn-success col-md-3 col-sm-4" name="btn-year1" id="btn-year1">Generar</button>
			                </div>
			                <!-- Card Body -->
			                <div class="card-body">
			                  <div class="chart-pie pt-4 pb-2">
			                    <canvas id="myPieChart"></canvas>
			                  </div>
			                  <div class="mt-4 text-center small">
			                    <span class="mr-2">
			                      <i class="fas fa-circle text-primary"></i> Publicaciones
			                    </span>
			                    <span class="mr-2">
			                      <i class="fas fa-circle text-success"></i> Aceptadas
			                    </span>
			                    <span class="mr-2">
			                      <i class="fas fa-circle text-danger"></i> No aceptadas
			                    </span>
			                  </div>
			                </div>
			              </div>
			            </div>
			        </div>
			        <div class="row" style="margin-top: 3em;">
			            <!-- Area Chart -->
			            <div class="col-xl-12 col-lg-12">
			              <div class="card shadow mb-4">
			                <!-- Card Header - Dropdown -->
			                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			                  <h6 class="col-md-6 col-sm-5 m-0 font-weight-bold text-primary">Donaciones aceptadas por mes</h6>
			                  <div class="form-group col-md-4 col-sm-4">
			                  	<input type="numbrer" class="form-control" name="year2" id="year2" >
			                  </div>
			                  <button type="button" class="btn btn-success col-md-2 col-sm-3" name="btn-year2" id="btn-year2">Generar</button>
			                </div>
			                <!-- Card Body -->
			                <div class="card-body">
			                  <div class="chart-area">
			                    <canvas id="chartDcxM" class="chartjs-render-monitor"></canvas>
			                  </div>
			                </div>
			              </div>
			            </div>
			        </div>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

	<!--My js-->

	<script src="<?= base_url('assets/js/my_charts.js') ?>"></script>
	
</body>

</html>
