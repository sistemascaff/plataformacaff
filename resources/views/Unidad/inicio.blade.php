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
            <li class="breadcrumb-item"><a href="{{route('unidades.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">UNIDADES</li>
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
        <h3 class="card-title font-weight-bold">UNIDADES</h3>
      </div>
      <div class="card-body">
        <a href="{{route('unidades.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('unidades.index')}}" method="GET">
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
            <a href="{{route('unidades.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ASIGNATURA</th>
                  <th>PERIODO</th>
                  <th>UNIDAD</th>
                  <th>P. ORDINAL</th>
                  <th>AVANCE</th>
                  <th>F. REGISTRO</th>
                  <th>F. ACTUALIZACION</th>
                  <th>MODIFICADO POR</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableUnidad as $rowUnidad)
                  <tr>
                    <td>{{$rowUnidad->nombreAsignatura}}</td>
                    <td>{{$rowUnidad->nombrePeriodo}}</td>
                    <td>{{$rowUnidad->nombreUnidad}}</td>
                    <td>{{$rowUnidad->posicionOrdinal}}</td>
                    <td>{{ round($rowUnidad->porcentajeAvance) . '%' }}
                      <div class="progress mb-3">
                          <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{ round($rowUnidad->porcentajeAvance) }}" aria-valuemin="0"
                               aria-valuemax="100" style="width: {{ round($rowUnidad->porcentajeAvance) . '%' }}">
                            <span class="sr-only">{{ round($rowUnidad->porcentajeAvance) . '%' }} Completado</span>
                          </div>
                      </div>
                    </td>
                    <td>{{helper_formatoVistaFechayHora($rowUnidad->fechaRegistro)}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowUnidad->fechaActualizacion)}}</td>
                    <td>{{helper_formatoNullorEmpty($rowUnidad->correo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('unidades.details', $rowUnidad->idUnidad)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('unidades.edit',$rowUnidad->idUnidad)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowUnidad->idUnidad}}" data-nombre="{{$rowUnidad->nombreUnidad}}">
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
          <form action="{{route('unidades.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idUnidad" value="0">
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