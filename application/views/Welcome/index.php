<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BusCOmida</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/fast-food.png') ?>" />

  <!-- Bootstrap core CSS -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template -->
  <!-- <link href="assets/css/grayscale.min.css" rel="stylesheet"> -->
  <link href="<?= base_url('assets/css/grayscale.min.css') ?>" rel="stylesheet">

</head>

<body id="page-top">
  <!-- Header -->
  <header class="masthead">
    <div class="container d-flex h-100 align-items-center">
      <div class="mx-auto text-center">
        <h1 class="mx-auto my-0">BusCOmida</h1>
        <h2 class="text-white-50 mx-auto mt-2 mb-5">El sitio web para realizar y recibir donaciones de alimentos.</h2>
        <h2 class="text-white-50 mx-auto mt-2 mb-5">Regístrate y haz parte de ésta gran comunidad.</h2>
        <div class="row">
          <div class="col-lg-4 mx-auto">
            <a href="<?= base_url('index.php/Register/register') ?>"  style="margin: 10px 0 0 0" class="btn btn-info js-scroll-trigger" style: marg>¡Regístrate!</a>
          </div>
          <div class="col-lg-4 mx-auto">
            <a href="<?= base_url('index.php/Login/login') ?>" style="margin: 10px 0 0 0" class="btn btn-info js-scroll-trigger">Iniciar Sesión</a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Bootstrap core JavaScript -->
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

  <!-- Plugin JavaScript -->
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

  <!-- Custom scripts for this template -->
  <script src="<?= base_url('assets/js/grayscale.min.js') ?>"></script>

</body>

</html>