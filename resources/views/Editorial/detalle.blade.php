@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$nombreEditorial}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('editoriales.index')}}">EDITORIALES</a></li>
            <li class="breadcrumb-item active">{{$nombreEditorial}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <div class="card-body">
        <h3 class="card-title font-weight-bold">LIBROS CON LA EDITORIAL "{{$nombreEditorial}}": <span class="text-info">{{ count($Libros) }}</span> REGISTROS.</h3>
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
            <td>{{ helper_FormatoAtributoValorATexto($rowLibros->adquisicion,'libroAdquisicion') }}</td>
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
  @include('Layouts.footerStart')
@include('Layouts.footerEnd')