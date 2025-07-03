@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$silabo->nombreSilabo}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('silabos.index')}}">SILABOS</a></li>
            <li class="breadcrumb-item active">{{$silabo->nombreSilabo}}</li>
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
          <a class="btn btn-info rounded" href="{{route('silabos.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning rounded" href="{{route('silabos.edit',$silabo->idSilabo)}}">
            {!! helper_FormatoBotonCRUD(3, 'texto') !!}
          </a>
          <a class="btn btn-danger rounded" data-toggle="modal" data-target="#modalDelete">
            {!! helper_FormatoBotonCRUD(4, 'texto') !!}
          </a>
          <form action="{{route('silabos.statusUpdate',$silabo->idSilabo)}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idSilabo" value="{{ $silabo->idSilabo }}">
            <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(11, 'texto') !!} AVANCE</button>
          </form>
        </div>
      </div>
      <div class="card-body">
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Silabo</label>
              <div class="col-md-10">
                <p class="form form-control">{{$silabo->nombreSilabo}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Asignatura</label>
              <div class="col-md-10">
                <a href="{{route('asignaturas.details', $asignatura->idAsignatura)}}" class="form form-control font-weight-bold">{{$asignatura->nombreAsignatura}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Unidad</label>
              <div class="col-md-10">
                <a href="{{route('unidades.details', $unidad->idUnidad)}}" class="form form-control font-weight-bold">{{$unidad->nombreUnidad}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Periodo</label>
              <div class="col-md-10">
                <a href="{{route('periodos.details', $periodo->idPeriodo)}}" class="form form-control font-weight-bold">{{$periodo->nombrePeriodo}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Estado</label>
              <div class="col-md-10">
                <p class="form form-control bg-info">{{helper_FormatoAtributoValorATexto($silabo->estado, 'silaboEstado')}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Inicio</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($silabo->fechaInicio)}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Fin</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($silabo->fechaFin)}}</p>
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
          <p class="font-weight-bold">{{$silabo->nombreSilabo}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('silabos.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idSilabo" value="{{$silabo->idSilabo}}">
            <button type="submit" class="btn btn-danger">{!! helper_FormatoBotonCRUD(4, 'texto') !!}</button>
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