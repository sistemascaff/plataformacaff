@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">BIENVENIDO, {{session('correo')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('presentaciones.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">PRESENTACIONES</li>
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
        <h3 class="card-title font-weight-bold">PRESENTACIONES: <span class="text-info">{{ count($tablePresentacion) }}</span> REGISTROS.</h3>
      </div>
      <div class="card-body">
        <a href="{{route('presentaciones.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('presentaciones.index')}}" method="GET">
          <div class="input-group input-group-sm col-md-3">
            <input type="text" name="busqueda" class="form-control" placeholder="Filtrar tabla..." value="{{$busqueda}}" autofocus>
            <span class="input-group-append">
            <button type="submit" class="btn btn-info btn-flat">{!! helper_FormatoBotonCRUD(8, 'texto') !!}</button>
            </span>
          </div>
        </form>
        <br>
        @if ($busqueda)
          <h3 class="font-weight-bold">
            Resultados de la búsqueda: "{{$busqueda}}" 
            <a href="{{route('presentaciones.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>PRESENTACION</th>
                  <th>LIBROS</th>
                  <th>F. REGISTRO</th>
                  <th>F. ACTUALIZACION</th>
                  <th>MODIFICADO POR</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tablePresentacion as $rowPresentacion)
                  <tr>
                    <td>{{$rowPresentacion->nombrePresentacion}}</td>
                    <td>{{$rowPresentacion->countLibros}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowPresentacion->fechaRegistro)}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowPresentacion->fechaActualizacion)}}</td>
                    <td>{{helper_formatoNullorEmpty($rowPresentacion->correo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('presentaciones.details', $rowPresentacion->idPresentacion)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('presentaciones.edit',$rowPresentacion->idPresentacion)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowPresentacion->idPresentacion}}" data-nombre="{{$rowPresentacion->nombrePresentacion}}">
                          {!! helper_FormatoBotonCRUD(4, 'icono') !!}
                        </a>                      
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>        
            </table>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>

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
          <p class="font-weight-bold">¿Está seguro/a de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold text-info" id="nombre">NOMBRE</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</button>
          <form action="{{route('presentaciones.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idPresentacion" value="0">
            <button type="submit" class="btn btn-danger">{!! helper_FormatoBotonCRUD(4, 'texto') !!}</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- /.content -->
  @include('Layouts.footerStart')
@include('Layouts.footerEnd')