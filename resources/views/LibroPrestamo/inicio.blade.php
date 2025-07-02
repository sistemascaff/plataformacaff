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
            <li class="breadcrumb-item"><a href="{{route('librosprestamos.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">PRÉSTAMOS DE LIBROS</li>
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
        <h3 class="card-title font-weight-bold">PRÉSTAMOS DE LIBROS: <span class="text-info">{{ count($tableLibroPrestamo) }}</span> REGISTROS.</h3>
      </div>
      <div class="card-body">
        <a href="{{route('librosprestamos.create')}}" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
        <br><br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('librosprestamos.index')}}" method="GET">
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
            <a href="{{route('librosprestamos.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>LECTOR</th>
                  <th>PERFIL</th>
                  <th>CURSO</th>
                  <th>CELULAR</th>
                  <th style="width: 30%;">LIBRO/S</th>
                  <th>F. DEVOLUCION OBJETIVO</th>
                  <th>DIAS DE RETRASO</th>
                  <th>F. REGISTRO</th>
                  <th>F. ACTUALIZACION</th>
                  <th>MODIFICADO POR</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableLibroPrestamo as $rowLibroPrestamo)
                  <tr>
                    <td>{{$rowLibroPrestamo->idLibrosPrestamo}}</td>
                    <td>{{ trim($rowLibroPrestamo->apellidoPaterno . ' ' . $rowLibroPrestamo->apellidoMaterno . ' ' . $rowLibroPrestamo->nombres) }}</td>
                    <td>{{$rowLibroPrestamo->tipoPerfil}}</td>
                    <td>{{$rowLibroPrestamo->nombreCurso}}</td>
                    <td>{{$rowLibroPrestamo->celular}}</td>
                    <td style="width: 30%;">{!! $rowLibroPrestamo->groupConcatLibros !!}</td>
                    <td>{{helper_formatoVistaFecha($rowLibroPrestamo->fechaDevolucion)}}</td>
                    <td>{!!$rowLibroPrestamo->diasRetraso!!}</td>
                    <td>{{helper_formatoVistaFechayHora($rowLibroPrestamo->fechaRegistro)}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowLibroPrestamo->fechaActualizacion)}}</td>
                    <td>{{helper_formatoNullorEmpty($rowLibroPrestamo->correo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('librosprestamos.details', $rowLibroPrestamo->idLibrosPrestamo)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                        <a class="btn btn-warning" href="{{route('librosprestamos.edit',$rowLibroPrestamo->idLibrosPrestamo)}}">
                          {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                        </a>
                        <a class="btn btn-dark" href="{{route('librosprestamos.imprimirComprobantePDF',$rowLibroPrestamo->idLibrosPrestamo)}}" target="_blank" rel="noopener noreferrer">
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
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>

  <!-- /.content -->
  @include('Layouts.footerStart')
@include('Layouts.footerEnd')