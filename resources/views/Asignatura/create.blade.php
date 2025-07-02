@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">REGISTRAR {{$Titulos}}</h1>
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
        <h3 class="card-title font-weight-bold">{{$Titulos}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <form class="form-horizontal" action="{{route('asignaturas.store')}}" method="POST" id="createForm">

              @csrf
              
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRE ASIGNATURA (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombreAsignatura') is-invalid @enderror"
                      name="nombreAsignatura" value="{{old('nombreAsignatura')}}" placeholder="ASIGNATURA" minlength="3" maxlength="100" required autofocus>
                  </div>
                  @error('nombreAsignatura')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ABREVIATURA (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombreCorto') is-invalid @enderror"
                      name="nombreCorto" value="{{old('nombreCorto')}}" placeholder="ABV." minlength="1" maxlength="5" required>
                  </div>
                  @error('nombreCorto')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIPO DE CALIFICACIÓN (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tipoCalificacion" required>
                      <option value="1" {{old('tipoCalificacion') == '1' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(1,'asignaturaTipoCalificacion')}}</option>
                      <option value="2" {{old('tipoCalificacion') == '2' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(2,'asignaturaTipoCalificacion')}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIPO DE BLOQUE (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tipoBloque" required>
                      <option value="1" {{old('tipoBloque') == '1' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(1,'asignaturaTipoBloque')}}</option>
                      <option value="2" {{old('tipoBloque') == '2' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(2,'asignaturaTipoBloque')}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIPO DE ASIGNATURA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tipoAsignatura" required>
                      <option value="1" {{old('tipoAsignatura') == '1' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(1,'asignaturaTipoAsignatura')}}</option>
                      <option value="2" {{old('tipoAsignatura') == '2' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(2,'asignaturaTipoAsignatura')}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="idMateria" class="col-sm-2 col-form-label">MATERIA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idMateria" id="idMateria" required>
                      @foreach ($Materias as $rowMaterias)
                      @if ($rowMaterias->idMateria == $idSelect)
                      <option value="{{$rowMaterias->idMateria}}" selected>{{$rowMaterias->nombreMateria}}</option>
                      @else
                      <option value="{{$rowMaterias->idMateria}}">{{$rowMaterias->nombreMateria}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">COORDINACIÓN</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idCoordinacion" required>
                      <option value="0" selected>NINGUNO</option>
                      @foreach ($Coordinaciones as $rowCoordinaciones)
                      @if ($rowCoordinaciones->idCoordinacion == $idSelect)
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
                      @if ($rowAulas->idAula == $idSelect)
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
                    <select class="form-control form-control-lg" name="idDocente" id="select2" required>
                      @foreach ($Docentes as $rowDocentes)
                      @if ($rowDocentes->idDocente == $idSelect)
                      <option value="{{$rowDocentes->idDocente}}" selected>{{trim($rowDocentes->apellidoPaterno . ' ' . $rowDocentes->apellidoMaterno . ' ' . $rowDocentes->nombres)}}</option>
                      @else
                      <option value="{{$rowDocentes->idDocente}}">{{trim($rowDocentes->apellidoPaterno . ' ' . $rowDocentes->apellidoMaterno . ' ' . $rowDocentes->nombres)}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success" id="createSubmitButton">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('asignaturas.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
              </form>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
@include('Layouts.footerStart')
@include('Layouts.footerEnd')