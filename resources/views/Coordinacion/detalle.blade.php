@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$coordinacion->nombreCoordinacion}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('coordinaciones.index')}}">COORDINACIONES</a></li>
            <li class="breadcrumb-item active">{{$coordinacion->nombreCoordinacion}}</li>
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
        <h3 class="card-title font-weight-bold">ACCIONES</h3>
        <br>
        <div class="btn-group">
          <a class="btn btn-info" href="{{route('coordinaciones.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning" href="{{route('coordinaciones.edit',$coordinacion->idCoordinacion)}}">
            {!! helper_FormatoBotonCRUD(3, 'texto') !!}
          </a>
          <a class="btn btn-danger" data-toggle="modal" data-target="#modalDelete">
            {!! helper_FormatoBotonCRUD(4, 'texto') !!}
          </a>
        </div>
      </div>
      <div class="card-body">
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Coordinacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{$coordinacion->nombreCoordinacion}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$coordinacion->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($coordinacion->fechaActualizacion)}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Actualizado por</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($usuario->correo)}}</p>
              </div>
            </div>
          </div>
        </div>

        <h3 class="card-title font-weight-bold">ASIGNATURAS DEPENDIENTES DE {{$coordinacion->nombreCoordinacion}}:</h3>
        <br><br>
        <a href="{{route('areas.create', $coordinacion->idCoordinacion)}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>

        <div class="col-md-12">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ASIGNATURA</th>
                <th>ABREVIATURA</th>
                <th>F. REGISTRO</th>
                <th>F. ACTUALIZACION</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
          @foreach ($Asignaturas as $rowAsignaturas)
          <tr>
            <td>{{$rowAsignaturas->nombreAsignatura}}</td>
            <td>{{$rowAsignaturas->nombreCorto}}</td>
            <td>{{helper_formatoVistaFecha($rowAsignaturas->fechaRegistro)}}</td>
            <td>{{helper_formatoNullorEmpty($rowAsignaturas->fechaActualizacion)}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-info" href="{{route('areas.details', $rowAsignaturas->idAsignatura)}}">
                  {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                </a>
                <a class="btn btn-warning" href="{{route('areas.edit', $rowAsignaturas->idAsignatura)}}">
                  {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                </a>
              </div>
            </td>
          </tr>
          @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->

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
          <p class="font-weight-bold">{{$coordinacion->nombreCoordinacion}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('coordinaciones.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idCoordinacion" value="{{$coordinacion->idCoordinacion}}">
            <button type="submit" class="btn btn-danger">{!! helper_FormatoBotonCRUD(4, 'texto') !!}</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  @include('layouts.footer')