@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">PRÉSTAMO DE LIBROS N° {{$libroprestamo->idLibrosPrestamo}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('librosprestamos.index')}}">PRÉSTAMO DE LIBRO/S</a></li>
            <li class="breadcrumb-item active">PRÉSTAMO N° {{$libroprestamo->idLibrosPrestamo}}</li>
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
          <a class="btn btn-info" href="{{route('librosprestamos.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning" href="{{route('librosprestamos.edit',$libroprestamo->idLibrosPrestamo)}}">
            {!! helper_FormatoBotonCRUD(3, 'texto') !!}
          </a>
          <a class="btn btn-dark" href="{{route('librosprestamos.imprimirComprobantePDF',$libroprestamo->idLibrosPrestamo)}}" target="_blank" rel="noopener noreferrer">
            {!! helper_FormatoBotonCRUD(12, 'texto') !!}
          </a>
        </div>
      </div>
      <div class="card-body">
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Persona</label>
              <div class="col-md-10">
                <p class="form form-control">{{ trim($persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres) }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Perfil</label>
              <div class="col-md-10">
                <p class="form form-control">{{ $persona->tipoPerfil }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Curso</label>
              <div class="col-md-10">
                <p class="form form-control">{{ $libroprestamo->nombreCurso }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Celular</label>
              <div class="col-md-10">
                <p class="form form-control">{{ $libroprestamo->celular }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Devolución Objetivo</label>
              <div class="col-md-10">
                <p class="form form-control">{{ helper_formatoVistaFecha($libroprestamo->fechaDevolucion) }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$libroprestamo->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($libroprestamo->fechaActualizacion)}}</p>
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
        
        <h3 class="card-title font-weight-bold">LIBROS PRESTADOS:</h3>
        <br><br>
        <div class="col-md-12">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>CÓDIGO</th>
                <th>TÍTULO</th>
                <th>AUTOR</th>
                <th>EDITORIAL</th>
                <th>FECHA DE RETORNO</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
          @foreach ($Libros as $rowLibros)
          <tr>
            <td>{{$rowLibros->codigoLibro}}</td>
            <td>{{$rowLibros->nombreLibro}}</td>
            <td>{{$rowLibros->nombreAutor}}</td>
            <td>{{$rowLibros->nombreEditorial}}</td>
            <td>{{helper_formatoVistaFecha($rowLibros->fechaRetorno)}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-info rounded" href="{{route('libros.details', $rowLibros->idLibro)}}">
                  {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                </a>
                <form action="{{route('librosprestamosdetalles.dateReturnUpdate',$libroprestamo->idLibrosPrestamo)}}" method="POST">
                  @csrf
                  @method('put')
                  <input type="hidden" name="idLibrosPrestamo" value="{{ $libroprestamo->idLibrosPrestamo }}">
                  <input type="hidden" name="idLibro" value="{{ $rowLibros->idLibro }}">
                  <input type="hidden" name="nombrePersona" value="{{ trim('(' . $persona->tipoPerfil . ') ' . $persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres) }}">
                  <button type="submit" class="btn {{$rowLibros->fechaRetorno ? 'btn-warning' : 'btn-success' }}">{!! $rowLibros->fechaRetorno ? helper_FormatoBotonCRUD(13, 'icono') : helper_FormatoBotonCRUD(11, 'icono') !!}</button>
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
          <p class="font-weight-bold">N° {{$libroprestamo->idLibrosPrestamo}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('librosprestamos.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idLibrosPrestamo" value="{{$libroprestamo->idLibrosPrestamo}}">
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