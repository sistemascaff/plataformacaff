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
            <li class="breadcrumb-item"><a href="{{route('asignaturas.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">ASIGNATURAS</li>
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
        <h3 class="card-title font-weight-bold">ASIGNATURAS</h3>
      </div>
      <div class="card-body">
        <a href="{{route('asignaturas.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('asignaturas.index')}}" method="GET">
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
            <a href="{{route('asignaturas.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>MATERIA</th>
                  <th>ASIGNATURA</th>
                  <th>ABREVIATURA</th>
                  <th>DOCENTE</th>
                  <th>TIPO DE ASIGNATURA</th>
                  <th>TIPO DE CALIFICACIÓN</th>
                  <th>TIPO DE BLOQUE</th>
                  <th>COORDINACION</th>
                  <th>AULA</th>
                  <th>F. REGISTRO</th>
                  <th>F. ACTUALIZACION</th>
                  <th>MODIFICADO POR</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableAsignatura as $rowAsignatura)
                  <tr>
                    <td>{{$rowAsignatura->nombreMateria}}</td>
                    <td>{{$rowAsignatura->nombreAsignatura}}</td>
                    <td>{{$rowAsignatura->nombreCorto}}</td>
                    <td>{{trim($rowAsignatura->docente_paterno . ' ' . $rowAsignatura->docente_materno . ' ' . $rowAsignatura->docente_nombre)}}</td>
                    <td>{{helper_FormatoAtributoValorATexto($rowAsignatura->tipoAsignatura, 'asignaturaTipoAsignatura')}}</td>
                    <td>{{helper_FormatoAtributoValorATexto($rowAsignatura->tipoCalificacion, 'asignaturaTipoCalificacion')}}</td>
                    <td>{{helper_FormatoAtributoValorATexto($rowAsignatura->tipoBloque, 'asignaturaTipoBloque')}}</td>
                    <td>{{helper_formatoNullorEmpty($rowAsignatura->nombreCoordinacion)}}</td>
                    <td>{{$rowAsignatura->nombreAula}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowAsignatura->fechaRegistro)}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowAsignatura->fechaActualizacion)}}</td>
                    <td>{{helper_formatoNullorEmpty($rowAsignatura->correo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('asignaturas.details', $rowAsignatura->idAsignatura)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('asignaturas.edit',$rowAsignatura->idAsignatura)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowAsignatura->idAsignatura}}" data-nombre="{{$rowAsignatura->nombreAsignatura}}">
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
          <form action="{{route('asignaturas.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idAsignatura" value="0">
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