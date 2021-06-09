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

</head>

<body class="bg-gradient-info">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">BusCOmida</h1>
                    <p class="text-gray-500 mb-0">Recuperación de contraseña</p>
                  </div><br>
                  <form class="user" method="POST" action="<?= base_url('index.php/Recover-pass/Rec_pass/updatePasswordWithCode') ?>">
                    <div class="form-group">
                      <input type="hidden" class="form-control form-control-user" required id="codigo_us" name="codigo_us" value="<?= $user ?>">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" required id="newPass" name="newPass" aria-describedby="emailHelp" placeholder="Ingresa tu nueva contraseña">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" required id="confPass" name="confPass" placeholder="Confirma tu nueva contraseña">
                    </div>
                    <button type="submit" class="btn btn-info btn-user btn-block">Recuperar contraseña</button>    
                    <br>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('index.php/Login/Login') ?>">Iniciar Sesión</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  
  <!--Sweetalert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

  <!-- Mensaje de error por si falla al iniciar sesion -->

  <?php if (isset($error) && $error == 'ERR_CON'): ?>
    <script>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Las contraseñas no coinciden, rectifiquelas por favor',
        })
    </script>
  <?php endif ?>

  <?php if (isset($error) && $error == 'ERR_CPW'): ?>
    <script>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Hubo un error al cambiar la contraseña, intentelo mas tarde',
        })
    </script>
  <?php endif ?>
</body>

</html>
