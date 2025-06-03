@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$libro->nombreLibro}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('libros.index')}}">LIBROS</a></li>
            <li class="breadcrumb-item active">{{$libro->nombreLibro}}</li>
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
          <a class="btn btn-info" href="{{route('libros.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning" href="{{route('libros.edit',$libro->idLibro)}}">
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
              <label for="inputEmail3" class="col-md-2 col-form-label">Libro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$libro->nombreLibro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Código</label>
              <div class="col-md-10">
                <p class="form form-control">{{$libro->codigoLibro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Año de Publicación</label>
              <div class="col-md-10">
                <p class="form form-control">{{$libro->anhoLibro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Costo</label>
              <div class="col-md-10">
                <p class="form form-control">{{$libro->costo}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Observación</label>
              <div class="col-md-10">
                <textarea class="form form-control" readonly>{{$libro->observacion}}</textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Descripción</label>
              <div class="col-md-10">
                <textarea class="form form-control" readonly>{{$libro->descripcion}}</textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Adquisición</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_FormatoAtributoValorATexto($libro->adquisicion, 'libroAdquisicion')}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Categoria</label>
              <div class="col-md-10">
                <a href="{{route('categorias.details', $categoria->idCategoria)}}" class="form form-control font-weight-bold" target="_blank" rel="noopener noreferrer">{{$categoria->nombreCategoria}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Autor</label>
              <div class="col-md-10">
                <a href="{{route('autores.details', $libro->nombreAutor)}}" class="form form-control font-weight-bold" target="_blank" rel="noopener noreferrer">{{$libro->nombreAutor}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Editorial</label>
              <div class="col-md-10">
                <a href="{{route('editoriales.details', $libro->nombreEditorial)}}" class="form form-control font-weight-bold" target="_blank" rel="noopener noreferrer">{{$libro->nombreEditorial}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Presentacion</label>
              <div class="col-md-10">
                <a href="{{route('presentaciones.details', $presentacion->idPresentacion)}}" class="form form-control font-weight-bold" target="_blank" rel="noopener noreferrer">{{$presentacion->nombrePresentacion}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Estado</label>
              <div class="col-md-10">
                <p class="form form-control font-weight-bold {{helper_formatoClassLibroEstado($libro->estado)}}">{{helper_FormatoAtributoValorATexto($libro->estado,'libroEstado')}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Prestado A</label>
              <div class="col-md-10">
                <p class="form form-control">{{$libro->prestadoA}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Ingreso Cooperativa</label>
              <div class="col-md-10">
                <p class="form form-control">{{ helper_formatoVistaFecha($libro->fechaIngresoCooperativa) }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$libro->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($libro->fechaActualizacion)}}</p>
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
        
        <h3 class="card-title font-weight-bold">HISTORIAL DE PRÉSTAMOS DE {{$libro->nombreLibro}}:</h3>
        <br><br>
        <div class="col-md-12">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>N°</th>
                <th>LECTOR</th>
                <th>PERFIL</th>
                <th>F. REGISTRO</th>
                <th>F. RETORNO</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
          @foreach ($Prestamos as $rowPrestamos)
          <tr>
            <td>{{$rowPrestamos->idLibrosPrestamo}}</td>
            <td>{{trim($rowPrestamos->apellidoPaterno . ' ' . $rowPrestamos->apellidoMaterno . ' ' . $rowPrestamos->nombres)}}</td>
            <td>{{$rowPrestamos->tipoPerfil}}</td>
            <td>{{helper_formatoVistaFechayHora($rowPrestamos->fechaRegistro)}}</td>
            <td>{{helper_formatoVistaFechayHora($rowPrestamos->fechaRetorno)}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-info" href="{{route('librosprestamos.details', $rowPrestamos->idLibrosPrestamo)}}">
                  {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                </a>
                <a class="btn btn-warning" href="{{route('librosprestamos.edit', $rowPrestamos->idLibrosPrestamo)}}">
                  {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                </a>
                <a class="btn btn-dark" href="{{route('librosprestamos.imprimirComprobantePDF', $rowPrestamos->idLibrosPrestamo)}}" target="_blank" rel="noopener noreferrer">
                  {!! helper_FormatoBotonCRUD(12, 'icono') !!}
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
          <p class="font-weight-bold">{{$libro->nombreLibro}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('libros.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idLibro" value="{{$libro->idLibro}}">
            <button type="submit" class="btn btn-danger">{!! helper_FormatoBotonCRUD(4, 'texto') !!}</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  @include('layouts.footer')