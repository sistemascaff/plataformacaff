@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$asignatura->nombreAsignatura}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('asignaturas.index')}}">ASIGNATURAS</a></li>
            <li class="breadcrumb-item active">{{$asignatura->nombreAsignatura}}</li>
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
          <a class="btn btn-info" href="{{route('asignaturas.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning" href="{{route('asignaturas.edit',$asignatura->idAsignatura)}}">
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
              <label for="inputEmail3" class="col-md-2 col-form-label">Asignatura</label>
              <div class="col-md-10">
                <p class="form form-control">{{$asignatura->nombreAsignatura}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Abreviatura</label>
              <div class="col-md-10">
                <p class="form form-control">{{$asignatura->nombreCorto}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Tipo de Calificación</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_FormatoAtributoValorATexto($asignatura->tipoCalificacion,'asignaturaTipoCalificacion')}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Tipo de Bloque</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_FormatoAtributoValorATexto($asignatura->tipoBloque,'asignaturaTipoBloque')}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Tipo de Asignatura</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_FormatoAtributoValorATexto($asignatura->tipoAsignatura,'asignaturaTipoAsignatura')}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Materia</label>
              <div class="col-md-10">
                <a href="{{route('materias.details', $materia->idMateria)}}" class="form form-control font-weight-bold">{{$materia->nombreMateria}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Coordinación</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($coordinacion->nombreCoordinacion)}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Aula</label>
              <div class="col-md-10">
                <a href="{{route('aulas.details', $aula->idAula)}}" class="form form-control font-weight-bold">{{$aula->nombreAula}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Profesor</label>
              <div class="col-md-10">
                <a href="{{route('profesores.details', $profesor->idProfesor)}}" class="form form-control font-weight-bold">{{$persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$asignatura->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($asignatura->fechaActualizacion)}}</p>
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
          <p>¿Está segur@ de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold">{{$asignatura->nombreAsignatura}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('asignaturas.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idAsignatura" value="{{$asignatura->idAsignatura}}">
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