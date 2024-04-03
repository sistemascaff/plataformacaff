<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{helper_tituloPagina()}} | INICIAR SESIÓN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/AdminLTE/plugins/font-awesome/css/font-awesome.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../public/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img src="../img/logo.png">
        <a href="" class="h1"><b>PLATAFORMA CAFF</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><b>INICIAR SESIÓN</b></p>

      <form action="{{route('login.verify')}}" method="POST">

        @csrf

        <div class="input-group mb-3">
          <input type="email" class="form-control" name="correo" required placeholder="CORREO">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="contrasenha" required placeholder="CONTRASEÑA">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-key"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="#">Olvidé mi contraseña</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../public/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>