@include('header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$curso->nombreCurso}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('cursos.index')}}">CURSOS</a></li>
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
        <h3 class="card-title font-weight-bold">{{$Titulos.': '.$curso->nombreCurso}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <form class="form-horizontal" action="{{route('cursos.update',$curso)}}" method="POST">

              @csrf
              @method('put')

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRE CURSO (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('nombreCurso') is-invalid @enderror"
                    name="nombreCurso" value="{{old('nombreCurso',$curso->nombreCurso)}}" placeholder="CURSO" minlength="5" maxlength="45" required autofocus>
                  </div>
                  @error('nombreCurso')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">GRADO (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idGrado" required>
                      @foreach ($Grados as $rowGrados)
                      @if ($rowGrados->idGrado == $curso->idGrado)
                      <option value="{{$rowGrados->idGrado}}" selected>{{$rowGrados->nombreGrado}}</option>
                      @else
                      <option value="{{$rowGrados->idGrado}}">{{$rowGrados->nombreGrado}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div><div class="form-group row">
                  <label class="col-sm-2 col-form-label">PARALELO (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idParalelo" required>
                      @foreach ($Paralelos as $rowParalelos)
                      @if ($rowParalelos->idParalelo == $curso->idParalelo)
                      <option value="{{$rowParalelos->idParalelo}}" selected>{{$rowParalelos->nombreParalelo}}</option>
                      @else
                      <option value="{{$rowParalelos->idParalelo}}">{{$rowParalelos->nombreParalelo}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              
              <a class="btn btn-warning" data-toggle="modal" data-target="#modalUpdate">
                {!! helper_FormatoBotonCRUD(3, 'texto') !!}
              </a>
              <a href="{{route('cursos.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>

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
  @include('footer')