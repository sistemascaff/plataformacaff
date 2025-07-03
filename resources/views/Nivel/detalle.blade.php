@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$nivel->nombreNivel}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('niveles.index')}}">NIVELES</a></li>
            <li class="breadcrumb-item active">{{$nivel->nombreNivel}}</li>
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
          <a class="btn btn-info" href="{{route('niveles.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning" href="{{route('niveles.edit',$nivel->idNivel)}}">
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
              <label for="inputEmail3" class="col-md-2 col-form-label">Nivel</label>
              <div class="col-md-10">
                <p class="form form-control">{{$nivel->nombreNivel}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Posición Ordinal</label>
              <div class="col-md-10">
                <p class="form form-control">{{$nivel->posicionOrdinal}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$nivel->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($nivel->fechaActualizacion)}}</p>
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

        <h3 class="card-title font-weight-bold">GRADOS DEPENDIENTES DE {{$nivel->nombreNivel}}:</h3>
        <br><br>
        <a href="{{route('grados.create', $nivel->idNivel)}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        

        <div class="col-md-12">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>GRADO</th>
                <th>P. ORDINAL</th>
                <th>F. REGISTRO</th>
                <th>F. ACTUALIZACION</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
          @foreach ($Grados as $rowGrados)
          <tr>
            <td>{{$rowGrados->nombreGrado}}</td>
            <td>{{$rowGrados->posicionOrdinal}}</td>
            <td>{{helper_formatoVistaFecha($rowGrados->fechaRegistro)}}</td>
            <td>{{helper_formatoNullorEmpty($rowGrados->fechaActualizacion)}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-info" href="{{route('grados.details', $rowGrados->idGrado)}}">
                  {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                </a>
                <a class="btn btn-warning" href="{{route('grados.edit', $rowGrados->idGrado)}}">
                  {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                </a>
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
          <p class="font-weight-bold">{{$nivel->nombreNivel}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('niveles.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idNivel" value="{{$nivel->idNivel}}">
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