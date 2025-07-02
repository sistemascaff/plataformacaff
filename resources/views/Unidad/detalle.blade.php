@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$unidad->nombreUnidad}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('unidades.index')}}">UNIDADES</a></li>
            <li class="breadcrumb-item active">{{$unidad->nombreUnidad}}</li>
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
          <a class="btn btn-info" href="{{route('unidades.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning" href="{{route('unidades.edit',$unidad->idUnidad)}}">
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
              <label for="inputEmail3" class="col-md-2 col-form-label">Unidad</label>
              <div class="col-md-10">
                <p class="form form-control">{{$unidad->nombreUnidad}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Posición Ordinal</label>
              <div class="col-md-10">
                <p class="form form-control">{{$unidad->posicionOrdinal}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Porcentaje de Avance</label>
              <div class="col-md-10">
                @php 
                $sumaEstados = 0;
                foreach ($Silabos as $rowSilabos) {
                  $sumaEstados += $rowSilabos->estado;
                }
                $porcentaje = 0;
                if (count($Silabos)) {
                  $porcentaje = ( $sumaEstados / (count($Silabos) * 2) * 100);
                }
                @endphp
                <p class="form form-control">{{ $porcentaje . '%'}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Asignatura</label>
              <div class="col-md-10">
                <a href="{{route('asignaturas.details', $asignatura->idAsignatura)}}" class="form form-control font-weight-bold">{{$asignatura->nombreAsignatura}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Periodo</label>
              <div class="col-md-10">
                <a href="{{route('periodos.details', $periodo->idPeriodo)}}" class="form form-control font-weight-bold">{{$periodo->nombrePeriodo}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$unidad->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($unidad->fechaActualizacion)}}</p>
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
        
        <h3 class="card-title font-weight-bold">SILABOS PERTENECIENTES A {{$unidad->nombreUnidad}}:</h3>
        <br><br>
        <a href="{{route('silabos.create', $unidad->idUnidad)}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>

        <div class="col-md-12">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>SILABO</th>
                <th>ESTADO</th>
                <th>F. INICIO</th>
                <th>F. FIN</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
          @foreach ($Silabos as $rowSilabos)
          <tr>
            <td>{{$rowSilabos->nombreSilabo}}</td>
            <td>{{helper_FormatoAtributoValorATexto($rowSilabos->estado, 'silaboEstado')}}</td>
            <td>{{helper_formatoVistaFechayHora($rowSilabos->fechaInicio)}}</td>
            <td>{{helper_formatoVistaFechayHora($rowSilabos->fechaFin)}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-info" href="{{route('silabos.details', $rowSilabos->idSilabo)}}">
                  {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                </a>
                <a class="btn btn-warning" href="{{route('silabos.edit', $rowSilabos->idSilabo)}}">
                  {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                </a>
                <form action="{{route('silabos.statusUpdate',$rowSilabos->idSilabo)}}" method="POST">
                  @csrf
                  @method('put')
                  <input type="hidden" name="idSilabo" value="{{ $rowSilabos->idSilabo }}">
                  <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(11, 'icono') !!}</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
            </tbody>
          </table>
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
          <p class="font-weight-bold">{{$unidad->nombreUnidad}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('unidades.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idUnidad" value="{{$unidad->idUnidad}}">
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