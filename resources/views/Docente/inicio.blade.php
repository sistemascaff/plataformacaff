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
            <li class="breadcrumb-item"><a href="{{route('docentes.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">DOCENTES</li>
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
        <h3 class="card-title font-weight-bold">DOCENTES: <span class="text-info">{{ count($tableDocente) }}</span> REGISTROS.</h3>
      </div>
      <div class="card-body">
        @if (session('rol_admin'))
          <a href="{{route('docentes.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
          <br><br>
          <!-- Formulario de búsqueda -->
        <form action="{{route('docentes.index')}}" method="GET">
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
            <a href="{{route('docentes.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
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
                  @if (session('rol_admin'))                    
                    <th>C.I.</th>
                    <th>C.I. COMP.</th>
                    <th>C.I. EXP.</th>
                    <th>F. NACIMIENTO</th>
                  @endif
                  <th>SEXO</th>
                  <th>IDIOMA</th>
                  <th>NIVEL I.E.</th>
                  <th>ESPECIALIDAD</th>
                  <th>GRADO DE ESTUDIOS</th>
                  @if (session('rol_admin'))
                    <th>DOMICILIO</th>
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
                @foreach ($tableDocente as $rowDocente)
                  <tr>
                    <td>{{$rowDocente->apellidoPaterno}}</td>
                    <td>{{$rowDocente->apellidoMaterno}}</td>
                    <td>{{$rowDocente->nombres}}</td>
                    @if (session('rol_admin'))
                    <td>{{$rowDocente->documentoIdentificacion}}</td>
                    <td>{{$rowDocente->documentoComplemento}}</td>
                    <td>{{$rowDocente->documentoExpedido}}</td>
                    <td>{{helper_formatoVistaFecha($rowDocente->fechaNacimiento)}}</td>
                    @endif
                    <td>{{$rowDocente->sexo}}</td>
                    <td>{{$rowDocente->idioma}}</td>
                    <td>{{$rowDocente->nivelIE}}</td>
                    <td>{{$rowDocente->especialidad}}</td>
                    <td>{{$rowDocente->gradoEstudios}}</td>
                    @if (session('rol_admin'))
                      <td>{{$rowDocente->direccionDomicilio}}</td>
                    @endif
                    <td>{{$rowDocente->correoPersonal}}</td>
                    @if (session('rol_admin'))
                      <td>{{helper_decrypt($rowDocente->contrasenha)}}</td>
                      <td>{{helper_formatoVistaFechayHora($rowDocente->fechaRegistro)}}</td>
                      <td>{{helper_formatoVistaFechayHora($rowDocente->fechaActualizacion)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowDocente->correo)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowDocente->ip)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowDocente->dispositivo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('docentes.details', $rowDocente->idDocente)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('docentes.edit',$rowDocente->idDocente)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowDocente->idDocente}}" data-nombre="{{$rowDocente->apellidoPaterno . ' ' . $rowDocente->apellidoMaterno . ' ' . $rowDocente->nombres}}">
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
          <p>¿Está segur@ de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold" id="nombre">NOMBRE</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</button>
          <form action="{{route('docentes.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idDocente" value="0">
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