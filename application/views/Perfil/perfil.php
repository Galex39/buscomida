<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Buscomida</title>
	<link rel="icon" type="image/png" href="<?= base_url('assets/img/fast-food.png') ?>" />
	
	<!-- Custom fonts for this template-->
	<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,
              800i,900,900i" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
	<!-- My css -->
  	<link href="<?= base_url('assets/css/my_css.css') ?>" rel="stylesheet">
  	<link rel="stylesheet" href="<?= base_url('assets/css/loader.css') ?>">
</head>

<body id="page-top">
	<!--Id usuario logueado-->
     <input type="hidden" id="id_us" name="id_us" value="<?=$this->session->userdata('buscomida_session')['codigo_us']?>">
     <input type="hidden" id="id_mun" name="id_mun" value="<?=$this->session->userdata('buscomida_session')['municipio']?>">
     <input type="hidden" id="state_us" name="state_us" value="<?=$this->session->userdata('buscomida_session')['estado']?>">
	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<!--Se carga el menu de la persona-->
		<?php echo $menu; ?>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<!-- Se carga la barra de navegacion superior -->
				<?php echo $nav;?>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">
					<!-- Portfolio Grid ------------------------------------------------------------------------------>
					<section class="bg-light page-section" id="portfolio">
						<div class="container">
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-12 text-center main-title">
										<h1 class="section-heading text-uppercase">Bienvenido a tu Perfil</h2>
									</div>
								</div>
								<!-- ****************************************************************************************** -->
								<div class="row">
									<div class="col-md-4 card-separation">
										<div class="card card-info">
											<div class="card-header">
												<h3 class="card-title card-text-pipe">FOTO DE PERFIL</h3>
											</div>
											<form role="form" method="POST" id="form-cimage">
												<div class="card-body">
													<div class="form-group">
														<img id="previewImagenUser" src="<?= base_url('assets/files/usuarios/'.$data = $this->session->userdata('buscomida_session')['foto']) ?>" alt=""
															style="width: 100%; height: 350px;">
													</div>
													<div class="form-group">
														<div class="input-group">
															<div class="custom-file">
																<input type="hidden" name="codigo_us" value="<?= $this->session->userdata('buscomida_session')['codigo_us'] ?>" >
																<input type="file" class="custom-file-input "
																	id="profileImage" name="profileImage">
																<label class="custom-file-label "
																	for="profileImage">Elige tu foto</label>
															</div>
														</div>
													</div>
												</div>
												<div class="card-footer">
													<div class="row justify-content-center">
														<button type="button" class="btn btn-info" id="btn-cimage">Cambiar</button>
													</div>
												</div>
											</form>
											<div class="load-container" id="waitEditarFotoUser">
												<div class="preloader"></div>
											</div>
										</div>
									</div>
									<div class="col-md-8 card-separation">
										<div class="card card-info">
											<div class="card-header">
												<h3 class="card-title card-text-pipe">DATOS BÁSICOS</h3>
											</div>
											<!-- form start -->
											<form role="form" method="POST" id="form-bdata">
												<div class="card-body">
													<div class="form-group">
														<input type="hidden" class="form-control" id="codigo_usd" name="codigo_us" value="<?= $this->session->userdata('buscomida_session')['codigo_us']?>">
													</div>
													<div class="form-group">
														<label for="...">Nombres</label>
														<input type="text" class="form-control" id="..."
															placeholder="Nombres" name="nombres" value="<?= $this->session->userdata('buscomida_session')['nombres']?>">
													</div>
													<div class="form-group">
														<label for="...">Apellidos</label>
														<input type="text" class="form-control" id="apellidos" placeholder="Apellidos" name="apellidos" value="<?= $this->session->userdata('buscomida_session')['apellidos'] ?>">
													</div>
													<div class="form-group">
														<label for="...">Correo</label>
														<input type="text" class="form-control" id="email" placeholder="Correo" name="email" value="<?= $this->session->userdata('buscomida_session')['email'] ?>">
													</div>
													<div class="form-group">
														<label for="...">Teléfono</label>
														<input type="text" class="form-control" id="telefono" placeholder="Teléfono" name="telefono" value="<?= $this->session->userdata('buscomida_session')['telefono'] ?>">
													</div>
													<div class="form-group row">
														<div class="col-sm-6 mb-3 mb-sm-0">
										                    <label for="...">Departamento</label>
										                </div>
										                <div class="col-sm-6 mb-3 mb-sm-0">
										                    <label for="...">Municipio</label>
										                </div>
										                <div class="col-sm-6 mb-3 mb-sm-0">
										                    <select class="form-control" required id="departamento" name="departamento">
										                    </select> 
										                </div>
										                <div class="col-sm-6 mb-3 mb-sm-0">
										                    <select class="form-control" required id="municipio" name="municipio">
										                    </select>
										                </div>
									                </div>
												</div>
												<div class="card-footer">
													<button type="button" class="btn btn-info" id="btn-edit-bdata">Editar datos básicos</button>
												</div>
											</form>
											<div class="load-container" id="waitEditarDataUser">
												<div class="preloader"></div>
											</div>
										</div>
									</div>
									<div class="col-md-12">
									</div>
									<div class="col-md-4">
									</div>
									<div class="col-md-8 card-separation" >
										<div class="card card-info">
											<div class="card-header">
												<h3 class="card-title card-text-pipe">CAMBIAR CONTRASEÑA</h3>
											</div>
											<!-- form start -->
											<form role="form" method="POST" id="form-uppass">
												<div class="card-body">
													<div class="form-group">
														<input type="hidden" class="form-control" id="codigo_usp" name="codigo_us" value="<?= $this->session->userdata('buscomida_session')['codigo_us']?>">
													</div>
													<div class="form-group">
														<label for="...">Contraseña actual</label>
														<input type="password" class="form-control" id="pw_act" name="pw_act" placeholder="La que usaste al ingresar...">
													</div>
													<div class="form-group">
														<label for="...">Nueva Contraseña </label>
														<input type="password" class="form-control" id="pw_n" name="pw_n" placeholder="Ingresa tu nueva contraseña...">
													</div>
													<div class="form-group">
														<label for="...">Confirmar contraseña</label>
														<input type="password" class="form-control" id="pw_nr" name="pw_nr" placeholder="Repite tu nueva contraseña...">
													</div>
												</div>
												<div class="card-footer">
													<button type="button" class="btn btn-info" id="btn-upass">Editar contraseña</button>
												</div>
											</form>
											<div class="load-container" id="waitEditarPassUser">
												<div class="preloader"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	</div>

	<!-- Footer -->
	<?= $footer ?>
	<!-- End of Footer -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Cerrar sesion Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">¿Estás listo para salir?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Selecciona "Cerrar sesión" si estás listo para salir de la aplicación.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-info" href="<?= base_url('index.php/Login/login/cerrar_session') ?>">Cerrar sesión</a>
				</div>
			</div>
		</div>
	</div>
	
	<!--Nueva publicación-->
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
    <div class="modal fade" id="confEnt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" id="btn-entregado" class="btn btn-info" data-dismiss="modal">Entregado</button>
          </div>
        </div>
      </div>
    </div>

	<!-- Bootstrap core JavaScript-->
	<script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

	<!-- Custom scripts for all pages-->
	<script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/adminlte.min.js') ?>"></script>
	<!--My jQuery Script-->
	<script src="<?= base_url('assets/js/profile.js') ?>"></script>
</body>

</html>
