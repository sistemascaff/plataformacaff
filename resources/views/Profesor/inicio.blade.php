@include('layouts.header')
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
            <li class="breadcrumb-item"><a href="{{route('profesores.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">PROFESORES</li>
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
        <h3 class="card-title font-weight-bold">PROFESORES</h3>
      </div>
      <div class="card-body">
        <a href="{{route('profesores.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('profesores.index')}}" method="GET">
          <div class="input-group input-group-sm col-md-3">
            <input type="text" name="busqueda" class="form-control" placeholder="Filtrar tabla..." value="{{$busqueda}}" autofocus>
            <span class="input-group-append">
            <button type="submit" class="btn btn-info btn-flat">{!! helper_FormatoBotonCRUD(8, 'texto') !!}</button>
            </span>
          </div>
        </form>
        <br>
        @if ($busqueda)
          <h3 class="font-weight-bold">
            Resultados de la búsqueda: "{{$busqueda}}" 
            <a href="{{route('profesores.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>AP. PATERNO</th>
                  <th>AP. MATERNO</th>
                  <th>NOMBRES</th>
                  <th>C.I.</th>
                  <th>C.I. COMP.</th>
                  <th>C.I. EXP.</th>
                  <th>F. NACIMIENTO</th>
                  <th>SEXO</th>
                  <th>IDIOMA</th>
                  <th>NIVEL I.E.</th>
                  <th>ESPECIALIDAD</th>
                  <th>GRADO DE ESTUDIOS</th>
                  <th>DOMICILIO</th>
                  <th>CORREO</th>
                  @if (session('rol_admin'))
                    <th>CONTRASEÑA</th>
                    <th>F. REGISTRO</th>
                    <th>F. ACTUALIZACION</th>
                    <th>MODIFICADO POR</th>
                    <th>IP</th>
                    <th>DISPOSITIVO</th>
                  @endif
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableProfesor as $rowProfesor)
                  <tr>
                    <td>{{$rowProfesor->apellidoPaterno}}</td>
                    <td>{{$rowProfesor->apellidoMaterno}}</td>
                    <td>{{$rowProfesor->nombres}}</td>
                    <td>{{$rowProfesor->documentoIdentificacion}}</td>
                    <td>{{$rowProfesor->documentoComplemento}}</td>
                    <td>{{$rowProfesor->documentoExpedido}}</td>
                    <td>{{helper_formatoVistaFecha($rowProfesor->fechaNacimiento)}}</td>
                    <td>{{$rowProfesor->sexo}}</td>
                    <td>{{$rowProfesor->idioma}}</td>
                    <td>{{$rowProfesor->nivelIE}}</td>
                    <td>{{$rowProfesor->especialidad}}</td>
                    <td>{{$rowProfesor->gradoEstudios}}</td>
                    <td>{{$rowProfesor->direccionDomicilio}}</td>
                    <td>{{$rowProfesor->correoPersonal}}</td>
                    @if (session('rol_admin'))
                      <td>{{helper_decrypt($rowProfesor->contrasenha)}}</td>
                      <td>{{helper_formatoVistaFechayHora($rowProfesor->fechaRegistro)}}</td>
                      <td>{{helper_formatoVistaFechayHora($rowProfesor->fechaActualizacion)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowProfesor->correo)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowProfesor->ip)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowProfesor->dispositivo)}}</td>
                    @endif
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('profesores.details', $rowProfesor->idProfesor)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('profesores.edit',$rowProfesor->idProfesor)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowProfesor->idProfesor}}" data-nombre="{{$rowProfesor->apellidoPaterno . ' ' . $rowProfesor->apellidoMaterno . ' ' . $rowProfesor->nombres}}">
                          {!! helper_FormatoBotonCRUD(4 , 'icono') !!}
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
    </div>
    <!-- /.card -->

  </section>

  <div class="modal fade" id="modalDelete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title font-weight-bold text-danger">ELIMINAR REGISTRO</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Está segur@ de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold" id="nombre">NOMBRE</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</button>
          <form action="{{route('profesores.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idProfesor" value="0">
            <button type="submit" class="btn btn-danger">{!! helper_FormatoBotonCRUD(4, 'texto') !!}</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- /.content -->
  @include('layouts.footer')