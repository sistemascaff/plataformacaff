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
            <li class="breadcrumb-item"><a href="{{route('unidades.index')}}">UNIDADES</a></li>
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
            <form class="form-horizontal" action="{{route('unidades.store')}}" method="POST" id="createForm">

              @csrf

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ASIGNATURA <span class="text-danger">(*)</span></label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idAsignatura" required>
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
                  <label class="col-sm-2 col-form-label">PERIODO <span class="text-danger">(*)</span></label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idPeriodo" required>
                      @foreach ($Periodos as $rowPeriodos)
                      <option value="{{$rowPeriodos->idPeriodo}}">{{$rowPeriodos->nombrePeriodo}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRE UNIDAD <span class="text-danger">(*)</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombreUnidad') is-invalid @enderror"
                      name="nombreUnidad" value="{{old('nombreUnidad')}}" placeholder="UNIDAD" minlength="1" maxlength="250" required autofocus>
                  </div>
                  @error('nombreUnidad')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">POSICIÓN ORDINAL <span class="text-danger">(*)</span></label>
                  <div class="col-sm-10">
                  <input type="number" class="form-control @error('posicionOrdinal') is-invalid @enderror"
                    name="posicionOrdinal" value="{{old('posicionOrdinal',1)}}" min="1" max="100" required>
                  </div>
                  @error('posicionOrdinal')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
              </div>
              <button type="submit" class="btn btn-success" id="createSubmitButton">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('unidades.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
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