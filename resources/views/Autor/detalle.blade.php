@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$autor->nombreAutor}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('autores.index')}}">AUTORES</a></li>
            <li class="breadcrumb-item active">{{$autor->nombreAutor}}</li>
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
          <a class="btn btn-info" href="{{route('autores.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning" href="{{route('autores.edit',$autor->idAutor)}}">
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
              <label for="inputEmail3" class="col-md-2 col-form-label">Autor</label>
              <div class="col-md-10">
                <p class="form form-control">{{$autor->nombreAutor}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$autor->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($autor->fechaActualizacion)}}</p>
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

        <h3 class="card-title font-weight-bold">LIBROS PERTENECIENTES A {{$autor->nombreAutor}}:</h3>
        <br><br>
        <div class="col-md-12">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>TÍTULO</th>
                <th>CÓDIGO</th>
                <th>COSTO</th>
                <th>ADQUISICION</th>
                <th>DESCRIPCIÓN</th>
                <th>OBSERVACIÓN</th>
                <th>PRESTADO A</th>
                <th>ESTADO</th>
                <th>F. REGISTRO</th>
                <th>F. ACTUALIZACION</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
          @foreach ($Libros as $rowLibros)
          <tr>
            <td>{{$rowLibros->nombreLibro}}</td>
            <td>{{$rowLibros->codigoLibro}}</td>
            <td>{{$rowLibros->costo}}</td>
            <td>{{$rowLibros->adquisicion}}</td>
            <td>{{$rowLibros->descripcion}}</td>
            <td>{{$rowLibros->observacion}}</td>
            <td>{{$rowLibros->prestadoA}}</td>
            <td class="font-weight-bold {{helper_formatoClassLibroEstado($rowLibros->estado)}}">{{helper_FormatoAtributoValorATexto($rowLibros->estado,'libroEstado')}}</td>
            <td>{{helper_formatoVistaFecha($rowLibros->fechaRegistro)}}</td>
            <td>{{helper_formatoNullorEmpty($rowLibros->fechaActualizacion)}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-info" href="{{route('libros.details', $rowLibros->idLibro)}}">
                  {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                </a>
                <a class="btn btn-warning" href="{{route('libros.edit', $rowLibros->idLibro)}}">
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
          <p class="font-weight-bold">{{$autor->nombreAutor}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('autores.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idAutor" value="{{$autor->idAutor}}">
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