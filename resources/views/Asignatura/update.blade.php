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
            <li class="breadcrumb-item active">{{$Titulos}}</li>
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
        <h3 class="card-title font-weight-bold">{{$Titulos.': '.$asignatura->nombreAsignatura}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <form class="form-horizontal" action="{{route('asignaturas.update',$asignatura)}}" method="POST">

              @csrf
              @method('put')

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRE ASIGNATURA (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('nombreAsignatura') is-invalid @enderror"
                    name="nombreAsignatura" value="{{old('nombreAsignatura', $asignatura->nombreAsignatura)}}" placeholder="ASIGNATURA" minlength="3" maxlength="100" required autofocus>
                  </div>
                  @error('nombreAsignatura')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ABREVIATURA (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('nombreCorto') is-invalid @enderror"
                    name="nombreCorto" value="{{old('nombreCorto', $asignatura->nombreCorto)}}" placeholder="ABV." minlength="1" maxlength="5" required>
                  </div>
                  @error('nombreCorto')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIPO DE CALIFICACIÓN (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tipoCalificacion" required>
                      <option value="1" {{$asignatura->tipoCalificacion == '1' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(1, 'asignaturaTipoCalificacion')}}</option>
                      <option value="2" {{$asignatura->tipoCalificacion == '2' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(2, 'asignaturaTipoCalificacion')}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIPO DE BLOQUE (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tipoBloque" required>
                      <option value="1" {{$asignatura->tipoBloque == '1' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(1, 'asignaturaTipoBloque')}}</option>
                      <option value="2" {{$asignatura->tipoBloque == '2' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(2, 'asignaturaTipoBloque')}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIPO DE ASIGNATURA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tipoAsignatura" required>
                      <option value="1" {{$asignatura->tipoAsignatura == '1' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(1, 'asignaturaTipoAsignatura')}}</option>
                      <option value="2" {{$asignatura->tipoAsignatura == '2' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(2, 'asignaturaTipoAsignatura')}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">MATERIA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idMateria" required>
                      @foreach ($Materias as $rowMaterias)
                      @if ($rowMaterias->idMateria == $asignatura->idMateria)
                      <option value="{{$rowMaterias->idMateria}}" selected>{{$rowMaterias->nombreMateria}}</option>
                      @else
                      <option value="{{$rowMaterias->idMateria}}">{{$rowMaterias->nombreMateria}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">COORDINACION</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idCoordinacion" required>
                      <option value="0" selected>NINGUNO</option>
                      @foreach ($Coordinaciones as $rowCoordinaciones)
                      @if ($rowCoordinaciones->idCoordinacion == $asignatura->idCoordinacion)
                      <option value="{{$rowCoordinaciones->idCoordinacion}}" selected>{{$rowCoordinaciones->nombreCoordinacion}}</option>
                      @else
                      <option value="{{$rowCoordinaciones->idCoordinacion}}">{{$rowCoordinaciones->nombreCoordinacion}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">AULA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idAula" required>
                      @foreach ($Aulas as $rowAulas)
                      @if ($rowAulas->idAula == $asignatura->idAula)
                      <option value="{{$rowAulas->idAula}}" selected>{{$rowAulas->nombreAula}}</option>
                      @else
                      <option value="{{$rowAulas->idAula}}">{{$rowAulas->nombreAula}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">DOCENTE (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idDocente" id="select2" required>
                      @foreach ($Docentes as $rowDocentes)
                      @if ($rowDocentes->idDocente == $asignatura->idDocente)
                      <option value="{{$rowDocentes->idDocente}}" selected>{{trim($rowDocentes->apellidoPaterno . ' ' . $rowDocentes->apellidoMaterno . ' ' . $rowDocentes->nombres)}}</option>
                      @else
                      <option value="{{$rowDocentes->idDocente}}">{{trim($rowDocentes->apellidoPaterno . ' ' . $rowDocentes->apellidoMaterno . ' ' . $rowDocentes->nombres)}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              
              <a class="btn btn-warning" data-toggle="modal" data-target="#modalUpdate">
                {!! helper_FormatoBotonCRUD(3, 'texto') !!}
              </a>
              <a href="{{route('asignaturas.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>

              <div class="modal fade" id="modalUpdate">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title font-weight-bold text-warning">EDITAR REGISTRO</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="font-weight-bold">¿Está segur@ de haber ingresado los datos correctamente? Presione EDITAR para confirmar.</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                      <button type="submit" class="btn btn-warning">{!! helper_FormatoBotonCRUD(3, 'texto') !!}</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->

              </form>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
@include('layouts.footerStart')
@include('layouts.footerEnd')