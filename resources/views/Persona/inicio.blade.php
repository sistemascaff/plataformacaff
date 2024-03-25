@include('header')
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
        <a href="{{route('usuarios.create')}}" class="btn btn-success">NUEVO REGISTRO</a>
        <br><br>
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>AP. PATERNO</th>
                  <th>AP. MATERNO</th>
                  <th>NOMBRES</th>
                  <th>FECHA NACIMIENTO</th>
                  <th>SEXO</th>
                  <th>IDIOMA</th>
                  <th>C.I.</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tablePersona as $rowPersona)
                  <tr>
                    <td>{{$rowPersona->apellidoPaterno}}</td>
                    <td>{{$rowPersona->apellidoMaterno}}</td>
                    <td>{{$rowPersona->nombres}}</td>
                    <td>{{formatoVistaFecha($rowPersona->fechaNacimiento)}}</td>
                    <td>{{$rowPersona->sexo}}</td>
                    <td>{{$rowPersona->idioma}}</td>
                    <td>{{$rowPersona->documentoIdentificacion}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('usuarios.details', $rowPersona->idPersona)}}">
                          <i class="fa fa-eye"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>        
            </table>
          </div>
        </div>
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
  @include('footer')