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

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">¡Crea tu cuenta!</h1>
              </div>
              <form class="user" method="POST" action="<?= base_url('index.php/Register/register/validar')?>">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" required id="name" name="name" placeholder="Nombres">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" required id="last_name" name="last_name" placeholder="Apellidos">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" required id="user_name" name="user_name" placeholder="Nombre Usuario">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" class="form-control form-control-user" required id="cel_number" name="cel_number" placeholder="Teléfono">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12 mb-6 mb-sm-0">
                    <input type="email" class="form-control form-control-user" required id="email" name="email" placeholder="Correo">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select class="form-control" style="border-radius: 10em; height: 3em;"  id="departamento" name="Departamento">
                      <option value="" selected>Seleccione un departamento</option>
                    </select>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0"> 
                    <select class="form-control" style="border-radius: 10em; height: 3em;" id="municipio" name="municipio">
                      <option value="" selected>Seleccione un municipio</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" required id="pw" name="pw" placeholder="Contraseña">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" required id="r_pw" name="r_pw" placeholder="Repite tu contraseña">
                  </div>
                </div>
                <button type="submit" class="btn btn-info btn-user btn-block">Registrar tu Cuenta</button>
              </form>
              <hr>
               <div class="text-center">
                <a class="small" href="<?= base_url('index.php/Recover-pass/Rec_pass') ?>">Olvidaste tu contraseña?</a>
              </div>
              <div class="text-center">
                <a class="small" href="<?= base_url('index.php/Login/login') ?>">¿Ya tienes una cuenta? ¡Iniciar sesión!</a>
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
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>
  <!--My js-->
  <script src="<?= base_url('assets/js/register.js') ?>"></script>


  <!-- Error de registro de usuario -->
  <?php if (isset($error) && $error=='ERR_REG'): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Hubo un problema al resgistrar el usuario, inténtalo mas tarde',
      })
    </script>
  <?php endif ?>
  <!-- Usuario en uso -->
  <?php if (isset($error) && $error=='ERR_US'): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'El usuario ya está en uso',
      })
    </script>
  <?php endif ?>
  <!-- Las contraseñas no coinciden -->
  <?php if (isset($error) && $error=='ERR_PASS'): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Las contraseñas no coinciden, rectifíquelas por favor',
      })
    </script>
  <?php endif ?>

</body>

</html>
