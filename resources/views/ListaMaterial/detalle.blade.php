@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">MATERIAL DE ASIGNATURA - {{$asignatura->nombreAsignatura}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('listasmateriales.index')}}">MATERIALES DE ASIGNATURAS</a></li>
            <li class="breadcrumb-item active">{{$listamaterial->nombreHorario}}</li>
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
          <a class="btn btn-info" href="{{route('listasmateriales.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <form action="{{route('listasmateriales.edit')}}" method="GET">
            <input type="hidden" name="idAsignatura" value="{{$listamaterial->idAsignatura}}">
            <input type="hidden" name="idMaterial" value="{{$listamaterial->idMaterial}}">
            <button type="submit" class="btn btn-warning">{!! helper_FormatoBotonCRUD(3, 'texto') !!}</button>
        </form>
          <a class="{{$listamaterial->estado ? 'btn btn-danger' : 'btn btn-success'}}" data-toggle="modal" data-target="#modalDelete">
            {!! $listamaterial->estado ? helper_FormatoBotonCRUD(4, 'texto') : helper_FormatoBotonCRUD(13, 'texto') !!}
          </a>
        </div>
      </div>
      <div class="card-body">
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Asignatura</label>
              <div class="col-md-10">
                <a href="{{route('asignaturas.details', $asignatura->idAsignatura)}}" class="form form-control font-weight-bold">{{$asignatura->nombreAsignatura}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Material</label>
              <div class="col-md-10">
                <a href="{{route('asignaturas.details', $material->idMaterial)}}" class="form form-control font-weight-bold">{{$material->nombreMaterial}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Cantidad</label>
              <div class="col-md-10">
                <p class="form form-control">{{ $listamaterial->cantidad }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Observación</label>
              <div class="col-md-10">
                <p class="form form-control">{{ $listamaterial->observacion }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$listamaterial->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($listamaterial->fechaActualizacion)}}</p>
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
          <p>¿Está seguro/a de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold">{{$asignatura->nombreAsignatura . ' - ' . $material->nombreMaterial }}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('listasmateriales.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idAsignatura" value="{{$listamaterial->idAsignatura}}">
            <input type="hidden" name="idMaterial" value="{{$listamaterial->idMaterial}}">
            <button type="submit" class="{{ $listamaterial->estado ? 'btn btn-danger' : 'btn btn-success' }}">{!! $listamaterial->estado ? helper_FormatoBotonCRUD(4, 'texto') : helper_FormatoBotonCRUD(13, 'texto') !!}</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  @include('Layouts.footerStart')
@include('Layouts.footerEnd')