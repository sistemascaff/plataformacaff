@include('Layouts.header')
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
            <li class="breadcrumb-item"><a href="{{route('estudiantes.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">ESTUDIANTES</li>
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
        <h3 class="card-title font-weight-bold">ESTUDIANTES: <span class="text-info">{{ count($tableEstudiante) }}</span> REGISTROS.</h3>
      </div>
      <div class="card-body">
        @if (session('rol_admin'))
        <a href="{{route('estudiantes.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('estudiantes.index')}}" method="GET">
          <div class="input-group input-group-sm col-md-3">
            <input type="text" name="busqueda" class="form-control" placeholder="Filtrar tabla..." value="{{$busqueda}}" autofocus>
            <span class="input-group-append">
            <button type="submit" class="btn btn-info btn-flat">{!! helper_FormatoBotonCRUD(8, 'texto') !!}</button>
            </span>
          </div>
        </form>
        <br>
        @endif
        
        @if ($busqueda)
          <h3 class="font-weight-bold">
            Resultados de la búsqueda: "{{$busqueda}}" 
            <a href="{{route('estudiantes.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>CURSO</th>
                  <th>AP. PATERNO</th>
                  <th>AP. MATERNO</th>
                  <th>NOMBRES</th>
                  @if (session('rol_admin'))
                  <th>C.I.</th>
                  <th>C.I. COMP.</th>
                  <th>C.I. EXP.</th>
                  <th>F. NACIMIENTO</th>
                  @endif
                  <th>SEXO</th>
                  <th>IDIOMA</th>
                  <th>NIVEL I.E.</th>
                  @if (session('rol_admin'))
                  <th>TIPO SANGRE</th>
                  <th>ALERGIAS</th>
                  <th>DATOS MÉDICOS</th>
                  @endif
                  <th>CORREO</th>
                  @if (session('rol_admin'))
                    <th>CONTRASEÑA</th>
                    <th>F. REGISTRO</th>
                    <th>F. ACTUALIZACION</th>
                    <th>MODIFICADO POR</th>
                    <th>IP</th>
                    <th>DISPOSITIVO</th>
                    <th>Acciones</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($tableEstudiante as $rowEstudiante)
                  <tr>
                    <td>{{$rowEstudiante->nombreCurso}}</td>
                    <td>{{$rowEstudiante->apellidoPaterno}}</td>
                    <td>{{$rowEstudiante->apellidoMaterno}}</td>
                    <td>{{$rowEstudiante->nombres}}</td>
                    @if (session('rol_admin'))
                    <td>{{$rowEstudiante->documentoIdentificacion}}</td>
                    <td>{{$rowEstudiante->documentoComplemento}}</td>
                    <td>{{$rowEstudiante->documentoExpedido}}</td>
                    <td>{{helper_formatoVistaFecha($rowEstudiante->fechaNacimiento)}}</td>
                    @endif
                    <td>{{$rowEstudiante->sexo}}</td>
                    <td>{{$rowEstudiante->idioma}}</td>
                    <td>{{$rowEstudiante->nivelIE}}</td>
                    @if (session('rol_admin'))
                    <td>{{$rowEstudiante->saludTipoSangre}}</td>
                    <td>{{$rowEstudiante->saludAlergias}}</td>
                    <td>{{$rowEstudiante->saludDatos}}</td>
                    @endif
                    <td>{{$rowEstudiante->correoPersonal}}</td>
                    @if (session('rol_admin'))
                      <td>{{helper_decrypt($rowEstudiante->contrasenha)}}</td>
                      <td>{{helper_formatoVistaFechayHora($rowEstudiante->fechaRegistro)}}</td>
                      <td>{{helper_formatoVistaFechayHora($rowEstudiante->fechaActualizacion)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowEstudiante->correo)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowEstudiante->ip)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowEstudiante->dispositivo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('estudiantes.details', $rowEstudiante->idEstudiante)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('estudiantes.edit',$rowEstudiante->idEstudiante)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowEstudiante->idEstudiante}}" data-nombre="{{$rowEstudiante->apellidoPaterno . ' ' . $rowEstudiante->apellidoMaterno . ' ' . $rowEstudiante->nombres}}">
                          {!! helper_FormatoBotonCRUD(4 , 'icono') !!}
                        </a>                      
                      </div>
                    </td>
                    @endif
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
          <p class="font-weight-bold">¿Está seguro/a de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold text-info" id="nombre">NOMBRE</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</button>
          <form action="{{route('estudiantes.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idEstudiante" value="0">
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
  @include('Layouts.footerStart')
@include('Layouts.footerEnd')