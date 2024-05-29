@include('layouts.header')
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
            <li class="breadcrumb-item"><a href="{{route('dimensiones.index')}}">DIMENSIONES</a></li>
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
            <form class="form-horizontal" action="{{route('dimensiones.store')}}" method="POST">

              @csrf

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRE DIMENSION (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombreDimension') is-invalid @enderror"
                      name="nombreDimension" value="{{old('nombreDimension')}}" placeholder="DIMENSION" minlength="1" maxlength="45" required autofocus>
                  </div>
                  @error('nombreDimension')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">PUNTAJE MÁXIMO (*)</label>
                  <div class="col-sm-10">
                  <input type="number" class="form-control @error('puntajeMaximo') is-invalid @enderror"
                    name="puntajeMaximo" value="{{old('puntajeMaximo',1)}}" min="0" max="100" required>
                  </div>
                  @error('puntajeMaximo')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIPO DE CÁLCULO (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tipoCalculo" required>
                      <option value="1">{{helper_FormatoAtributoValorATexto(1, 'dimensionTipoCalculo')}}</option>
                      <option value="2">{{helper_FormatoAtributoValorATexto(2, 'dimensionTipoCalculo')}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">PERIODO (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idPeriodo" required>
                      @foreach ($Periodos as $rowPeriodos)
                      @if ($rowPeriodos->idPeriodo == $idSelect)
                      <option value="{{$rowPeriodos->idPeriodo}}" selected>{{'(' . $rowPeriodos->anhoGestion . ') ' . $rowPeriodos->nombrePeriodo}}</option>
                      @else
                      <option value="{{$rowPeriodos->idPeriodo}}">{{'(' . $rowPeriodos->anhoGestion . ') ' . $rowPeriodos->nombrePeriodo}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('dimensiones.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
              </form>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
  @include('layouts.footer')