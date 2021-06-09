<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Tables</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/fast-food.png') ?>" />

  <!-- Custom fonts for this template -->
  <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link rel="stylesheet"  type="text/css" href="<?= base_url('assets/vendor/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') ?>">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?= $menu ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?= $nav ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-12 text-center">
              <h2 class="section-heading text-uppercase">Ver administradores</h2>
              <h3 class="section-subheading text-muted">Aquí podrás encontrar listados los administradores del sitio</h3>
            </div>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4" style="margin-top: 4em;">
            <div class="card-header py-3 row">
              <h6 class="m-0 font-weight-bold text-primary col-md-11">Administradores del sitio</h6>
              <button class="btn btn-success" data-toggle="modal" data-target=".newAdmin"><i class="fas fa-plus-square"></i></button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tableAdmin" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Teléfono</th>
                      <th>Email</th>
                      <th>Municipio</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Teléfono</th>
                      <th>Email</th>
                      <th>Municipio</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?= $footer ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Nuevo admin -->
  <div class="modal fade bd-example-modal-lg newAdmin" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nuevo Administrador</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="user" method="POST" id="formAdmin">
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control input-admin" required id="name" name="name" placeholder="Nombres">
              </div>
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control input-admin" required id="last_name" name="last_name" placeholder="Apellidos">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control input-admin" required id="user_name" name="user_name" placeholder="Nombre Usuario">
              </div>
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="number" class="form-control input-admin" required id="cel_number" name="cel_number" placeholder="Telefono">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12 mb-6 mb-sm-0">
                <input type="email" class="form-control   input-admin" required id="email" name="email" placeholder="Correo">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <select class="form-control input-admin" id="departamento" name="departamento">
                  <option value="" selected>Seleccione un departamento</option>
                </select>
              </div>
              <div class="col-sm-6 mb-3 mb-sm-0"> 
                <select class="form-control input-admin" id="municipio" name="municipio">
                  <option value="" selected>Seleccione un municipio</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" class="form-control input-admin" required id="pw" name="pw" placeholder="Contraseña">
              </div>
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" class="form-control input-admin" required id="r_pw" name="r_pw" placeholder="Repite tu contraseña">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="button" id="btn-registrarAdmin">Guardar</button>
          <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

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
          <a class="btn btn-success" href="<?= base_url('index.php/Login/login/cerrar_session') ?>">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

  <!-- Page level plugins -->
  <script type="text/javascript" src="<?= base_url('assets/vendor/datatables/datatables.min.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <!-- Page level custom scripts -->
  <script src="<?= base_url('assets/js/verAdmin.js') ?>"></script>

</body>

</html>
