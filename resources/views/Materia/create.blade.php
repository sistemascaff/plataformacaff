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
            <li class="breadcrumb-item"><a href="{{route('materias.index')}}">MATERIAS</a></li>
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
            <form class="form-horizontal" action="{{route('materias.store')}}" method="POST">

              @csrf

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRE MATERIA (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombreMateria') is-invalid @enderror"
                      name="nombreMateria" value="{{old('nombreMateria')}}" placeholder="MATERIA" minlength="3" maxlength="45" required autofocus>
                  </div>
                  @error('nombreMateria')
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
                  <label class="col-sm-2 col-form-label">TIPO DE MATERIA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tipoMateria" required>
                      <option value="1">CUALITATIVA</option>
                      <option value="2">CUANTITATIVA</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">AREA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idArea" required>
                      @foreach ($Areas as $rowAreas)
                      @if ($rowAreas->idArea == $idSelect)
                      <option value="{{$rowAreas->idArea}}" selected>{{$rowAreas->nombreArea}}</option>
                      @else
                      <option value="{{$rowAreas->idArea}}">{{$rowAreas->nombreArea}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('materias.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
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