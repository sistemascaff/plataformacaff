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
            <li class="breadcrumb-item"><a href="{{route('libros.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">LIBROS</li>
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
        <h3 class="card-title font-weight-bold">LIBROS: <span class="text-info">{{ count($tableLibro) }}</span> REGISTROS.</h3>
      </div>
      <div class="card-body">
        <a href="{{route('libros.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('libros.index')}}" method="GET">
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
            <a href="{{route('libros.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>CATEGORÍA</th>
                  <th>CÓDIGO</th>
                  <th>TÍTULO</th>
                  <th>AUTOR</th>
                  <th>EDITORIAL</th>
                  <th>AÑO</th>
                  <th>DESCRIPCIÓN</th>
                  <th>COSTO</th>
                  <th>ADQUISICIÓN</th>
                  <th>PRESENTACIÓN</th>
                  <th>OBSERVACIÓN</th>
                  <th>PRESTADO A</th>
                  <th>F. INGRESO COOPERATIVA</th>
                  <th>CANT. PRÉSTAMOS</th>
                  <th>ESTADO</th>
                  <th>F. REGISTRO</th>
                  <th>F. ACTUALIZACION</th>
                  <th>MODIFICADO POR</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableLibro as $rowLibro)
                  <tr>
                    <td>{{$rowLibro->nombreCategoria}}</td>
                    <td>{{$rowLibro->codigoLibro}}</td>
                    <td>{{$rowLibro->nombreLibro}}</td>
                    <td>{{$rowLibro->nombreAutor}}</td>
                    <td>{{$rowLibro->nombreEditorial}}</td>
                    <td>{{$rowLibro->anhoLibro}}</td>
                    <td>{{$rowLibro->descripcion}}</td>
                    <td>{{$rowLibro->costo}}</td>
                    <td>{{helper_FormatoAtributoValorATexto($rowLibro->adquisicion, 'libroAdquisicion')}}</td>
                    <td>{{$rowLibro->nombrePresentacion}}</td>
                    <td>{{$rowLibro->observacion}}</td>
                    <td>{{$rowLibro->prestadoA}}</td>
                    <td>{{helper_formatoVistaFecha($rowLibro->fechaIngresoCooperativa)}}</td>
                    <td>{{$rowLibro->countLibrosPrestamos}}</td>
                    <td class="font-weight-bold"><div class="{{helper_formatoClassLibroEstado($rowLibro->estado)}}">{{helper_FormatoAtributoValorATexto($rowLibro->estado, 'libroEstado')}}</div></td>
                    <td>{{helper_formatoVistaFechayHora($rowLibro->fechaRegistro)}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowLibro->fechaActualizacion)}}</td>
                    <td>{{helper_formatoNullorEmpty($rowLibro->correo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('libros.details', $rowLibro->idLibro)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('libros.edit',$rowLibro->idLibro)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        @if ($rowLibro->estado == 1)
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowLibro->idLibro}}" data-nombre="{{$rowLibro->nombreLibro}}">
                          {!! helper_FormatoBotonCRUD(4 , 'icono') !!}
                        </a>
                        @endif           
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
          <p>¿Está segur@ de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold" id="nombre">NOMBRE</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</button>
          <form action="{{route('libros.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idLibro" value="0">
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