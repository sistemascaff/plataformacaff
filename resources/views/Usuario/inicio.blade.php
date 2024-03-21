@include('Usuario.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">BIENVENIDO, {{session('correo')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">USUARIOS</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title font-weight-bold">USUARIOS</h3>
      </div>
      <div class="card-body">

        <table id="dataTable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>idUsuario</th>
              <th>idPersona</th>
              <th>idRol</th>
              <th>correo</th>
              <th>contrasenha</th>
              <th>pinRecuperacion</th>
              <th>hashRecuperacion</th>
              <th>tieneAcceso</th>
              <th>estado</th>
              <th>fechaRegistro</th>
              <th>fechaActualizacion</th>
              <th>ultimaConexion</th>
              <th>idUsuarioResponsable</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tableUsuario as $rowUsuario)
              <tr>
                <td>{{$rowUsuario->idUsuario}}</td>
                <td>{{$rowUsuario->idPersona}}</td>
                <td>{{$rowUsuario->idRol}}</td>
                <td>{{$rowUsuario->correo}}</td>
                <td>{{$rowUsuario->contrasenha}}</td>
                <td>{{$rowUsuario->pinRecuperacion}}</td>
                <td>{{$rowUsuario->hashRecuperacion}}</td>
                <td>{{$rowUsuario->tieneAcceso}}</td>
                <td>{{$rowUsuario->estado}}</td>
                <td>{{$rowUsuario->fechaRegistro}}</td>
                <td>{{$rowUsuario->fechaActualizacion}}</td>
                <td>{{$rowUsuario->ultimaConexion}}</td>
                <td>{{$rowUsuario->idUsuarioResponsable}}</td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-info" href="{{route('usuarios.details', $rowUsuario->idUsuario)}}">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>        
        </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        FOOTER LOREM IPSUM
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
  @include('Usuario.footer')