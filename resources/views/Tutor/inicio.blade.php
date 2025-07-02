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
            <li class="breadcrumb-item"><a href="{{route('tutores.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">TUTORES</li>
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
        <h3 class="card-title font-weight-bold">TUTORES: <span class="text-info">{{ count($tableTutor) }}</span> REGISTROS.</h3>
      </div>
      <div class="card-body">
        <a href="{{route('tutores.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('tutores.index')}}" method="GET">
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
            <a href="{{route('tutores.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
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
                  <th>CELULAR</th>
                  <th>TELÉFONO</th>
                  <th>RELACIÓN ESTUDIANTE</th>
                  <th>G. INSTRUCCIÓN</th>
                  <th>E. NOMBRE EMPRESA</th>
                  <th>E. OCUPACIÓN</th>
                  <th>E. DIRECCIÓN</th>
                  <th>E. CORREO</th>
                  <th>E. TELÉFONO</th>
                  <th>E. CELULAR</th>
                  <th>R. DEPARTAMENTO</th>
                  <th>R. PROVINCIA</th>
                  <th>R. SECCION/MUNICIPIO</th>
                  <th>R. LOCALIDAD/COMUNIDAD</th>
                  <th>R. ZONA/VILLA</th>
                  <th>R. AVENIDA/CALLE</th>
                  <th>R. NÚMERO VIVIENDA</th>
                  <th>R. PUNTO REFERENCIA</th>
                  <th>CÓDIGO SOCIO</th>
                  <th>F. RAZÓN SOCIAL</th>
                  <th>F. NIT O C.I.</th>
                  @if (session('rol_admin'))
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
                @foreach ($tableTutor as $rowTutor)
                  <tr>
                    <td>{{$rowTutor->apellidoPaterno}}</td>
                    <td>{{$rowTutor->apellidoMaterno}}</td>
                    <td>{{$rowTutor->nombres}}</td>
                    <td>{{$rowTutor->documentoIdentificacion}}</td>
                    <td>{{$rowTutor->documentoComplemento}}</td>
                    <td>{{$rowTutor->documentoExpedido}}</td>
                    <td>{{helper_formatoVistaFecha($rowTutor->fechaNacimiento)}}</td>
                    <td>{{$rowTutor->sexo}}</td>
                    <td>{{$rowTutor->idioma}}</td>
                    <td>{{$rowTutor->celularPersonal}}</td>
                    <td>{{$rowTutor->telefonoPersonal}}</td>
                    <td>{{$rowTutor->relacionEstudiante}}</td>
                    <td>{{$rowTutor->gradoInstruccion}}</td>
                    <td>{{$rowTutor->empleoNombreEmpresa}}</td>
                    <td>{{$rowTutor->empleoOcupacionLaboral}}</td>
                    <td>{{$rowTutor->empleoDireccion}}</td>
                    <td>{{$rowTutor->empleoCorreo}}</td>
                    <td>{{$rowTutor->empleoTelefono}}</td>
                    <td>{{$rowTutor->empleoCelular}}</td>
                    <td>{{$rowTutor->rudeDepartamento}}</td>
                    <td>{{$rowTutor->rudeProvincia}}</td>
                    <td>{{$rowTutor->rudeSeccionOMunicipio}}</td>
                    <td>{{$rowTutor->rudeLocalidadOComunidad}}</td>
                    <td>{{$rowTutor->rudeZonaOVilla}}</td>
                    <td>{{$rowTutor->rudeAvenidaOCalle}}</td>
                    <td>{{$rowTutor->rudeNumeroVivienda}}</td>
                    <td>{{$rowTutor->rudePuntoReferencia}}</td>
                    <td>{{$rowTutor->codigoSocio}}</td>
                    <td>{{$rowTutor->facturacionRazonSocial}}</td>
                    <td>{{$rowTutor->facturacionNITCI}}</td>
                    @if (session('rol_admin'))
                      <td>{{helper_formatoVistaFechayHora($rowTutor->fechaRegistro)}}</td>
                      <td>{{helper_formatoVistaFechayHora($rowTutor->fechaActualizacion)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowTutor->correo)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowTutor->ip)}}</td>
                      <td>{{helper_formatoNullorEmpty($rowTutor->dispositivo)}}</td>
                    @endif
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('tutores.details', $rowTutor->idTutor)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('tutores.edit',$rowTutor->idTutor)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowTutor->idTutor}}" data-nombre="{{$rowTutor->apellidoPaterno . ' ' . $rowTutor->apellidoMaterno . ' ' . $rowTutor->nombres}}">
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
          <form action="{{route('tutores.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idTutor" value="0">
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