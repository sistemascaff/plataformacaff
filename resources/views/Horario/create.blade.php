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
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('horarios.index')}}">HORARIOS</a></li>
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
            <form class="form-horizontal" action="{{route('horarios.store')}}" method="POST" id="createForm">

              @csrf

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ASIGNATURA <span class="text-danger">(*)</span></label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idAsignatura" id="select2" required>
                      @foreach ($Asignaturas as $rowAsignaturas)
                      @if ($rowAsignaturas->idAsignatura == $idSelect)
                      <option value="{{$rowAsignaturas->idAsignatura}}" selected>{{$rowAsignaturas->nombreAsignatura}}</option>
                      @else
                      <option value="{{$rowAsignaturas->idAsignatura}}">{{$rowAsignaturas->nombreAsignatura}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">DIA <span class="text-danger">(*)</span></label>
                  <div class="col-sm-10">
                    <select class="form-control" name="dia" required>
                      <option value="1" selected>{{ helper_FormatoAtributoValorATexto(1, 'horarioDia') }}</option>
                      <option value="2">{{ helper_FormatoAtributoValorATexto(2, 'horarioDia') }}</option>
                      <option value="3">{{ helper_FormatoAtributoValorATexto(3, 'horarioDia') }}</option>
                      <option value="4">{{ helper_FormatoAtributoValorATexto(4, 'horarioDia') }}</option>
                      <option value="5">{{ helper_FormatoAtributoValorATexto(5, 'horarioDia') }}</option>
                      <option value="6">{{ helper_FormatoAtributoValorATexto(6, 'horarioDia') }}</option>
                      <option value="7">{{ helper_FormatoAtributoValorATexto(7, 'horarioDia') }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">HORA INICIO <span class="text-danger">(*)</span></label>
                  <div class="col-sm-10">
                    <input type="time" class="form-control @error('horaInicio') is-invalid @enderror"
                    name="horaInicio" value="{{old('horaInicio','08:00')}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">HORA FIN <span class="text-danger">(*)</span></label>
                  <div class="col-sm-10">
                    <input type="time" class="form-control @error('horaFin') is-invalid @enderror"
                    name="horaFin" value="{{old('horaFin','08:00')}}" required>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success" id="createSubmitButton">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('horarios.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
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