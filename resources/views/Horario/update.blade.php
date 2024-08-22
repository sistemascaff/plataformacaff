@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$horario->horaInicio}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
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
        <h3 class="card-title font-weight-bold">{{$Titulos.': '.$horario->horaInicio}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <form class="form-horizontal" action="{{route('horarios.update',$horario)}}" method="POST">

              @csrf
              @method('put')

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ASIGNATURA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idAsignatura" id="select2" required>
                      @foreach ($Asignaturas as $rowAsignaturas)
                      @if ($rowAsignaturas->idAsignatura == $horario->idAsignatura)
                      <option value="{{$rowAsignaturas->idAsignatura}}" selected>{{$rowAsignaturas->nombreAsignatura}}</option>
                      @else
                      <option value="{{$rowAsignaturas->idAsignatura}}">{{$rowAsignaturas->nombreAsignatura}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">DIA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="dia" required>
                      <option value="1" {{ $horario->dia == '1' ? 'selected' : '' }}>{{ helper_FormatoAtributoValorATexto(1, 'horarioDia') }}</option>
                      <option value="2" {{ $horario->dia == '2' ? 'selected' : '' }}>{{ helper_FormatoAtributoValorATexto(2, 'horarioDia') }}</option>
                      <option value="3" {{ $horario->dia == '3' ? 'selected' : '' }}>{{ helper_FormatoAtributoValorATexto(3, 'horarioDia') }}</option>
                      <option value="4" {{ $horario->dia == '4' ? 'selected' : '' }}>{{ helper_FormatoAtributoValorATexto(4, 'horarioDia') }}</option>
                      <option value="5" {{ $horario->dia == '5' ? 'selected' : '' }}>{{ helper_FormatoAtributoValorATexto(5, 'horarioDia') }}</option>
                      <option value="6" {{ $horario->dia == '6' ? 'selected' : '' }}>{{ helper_FormatoAtributoValorATexto(6, 'horarioDia') }}</option>
                      <option value="7" {{ $horario->dia == '7' ? 'selected' : '' }}>{{ helper_FormatoAtributoValorATexto(7, 'horarioDia') }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">HORA INICIO (*)</label>
                  <div class="col-sm-10">
                  <input type="time" class="form-control @error('horaInicio') is-invalid @enderror"
                    name="horaInicio" value="{{old('horaInicio', substr($horario->horaInicio, 0, -3))}}" required>
                  </div>
                  @error('horaInicio')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">HORA FIN (*)</label>
                  <div class="col-sm-10">
                  <input type="time" class="form-control @error('horaFin') is-invalid @enderror"
                    name="horaFin" value="{{old('horaFin', substr($horario->horaFin, 0, -3))}}" required>
                  </div>
                  @error('horaFin')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
              </div>
              
              <a class="btn btn-warning" data-toggle="modal" data-target="#modalUpdate">
                {!! helper_FormatoBotonCRUD(3, 'texto') !!}
              </a>
              <a href="{{route('horarios.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>

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
  @include('layouts.footer')