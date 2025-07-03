@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">REGISTRAR {{$Titulos}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('librosprestamos.index')}}">PRÉSTAMOS DE LIBROS</a></li>
            <li class="breadcrumb-item active">{{$Titulos}}</li>
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
        <h3 class="card-title font-weight-bold">{{$Titulos}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" action="{{route('librosprestamos.store')}}" method="POST" id="addBookLendingForm">

              <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
              
              <div class="card-body">
                <div class="form-group row">
                  <h3 class="font-weight-bold text-info rounded">PERSONA</h3>
                  <div class="col-sm-12">
                    <select class="form-control" name="idPersona" required id="select2">
                      <option value="0" disabled selected>--SELECCIONE UNA PERSONA--</option>
                      @foreach ($Personas as $rowPersonas)
                      @if ($rowPersonas->idPersona == $idSelect)
                      <option value="{{$rowPersonas->idPersona}}" selected>{{trim($rowPersonas->apellidoPaterno . ' ' . $rowPersonas->apellidoMaterno . ' ' . $rowPersonas->nombres) . ' (' . $rowPersonas->tipoPerfil . ')'}} {{$rowPersonas->nombreCurso ? helper_abreviarCurso($rowPersonas->nombreCurso) : ''}} {{ $rowPersonas->totalLibrosPrestados > 0 ? ' - ' . $rowPersonas->totalLibrosPrestados . ' LIBROS PRESTADOS EN TOTAL.' : '' }} {{ $rowPersonas->totalLibrosAdeudados > 0 ? ' - ' . $rowPersonas->totalLibrosAdeudados . ' LIBROS ADEUDADOS.' : '' }}</option>
                      @else
                      <option value="{{$rowPersonas->idPersona}}">{{trim($rowPersonas->apellidoPaterno . ' ' . $rowPersonas->apellidoMaterno . ' ' . $rowPersonas->nombres) . ' (' . $rowPersonas->tipoPerfil . ')'}} {{$rowPersonas->nombreCurso ? helper_abreviarCurso($rowPersonas->nombreCurso) : ''}} {{ $rowPersonas->totalLibrosPrestados > 0 ? ' - ' . $rowPersonas->totalLibrosPrestados . ' LIBROS PRESTADOS EN TOTAL.' : '' }} {{ $rowPersonas->totalLibrosAdeudados > 0 ? ' - ' . $rowPersonas->totalLibrosAdeudados . ' LIBROS ADEUDADOS.' : '' }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <h3 class="font-weight-bold text-info rounded">CELULAR</h3>
                  <div class="col-sm-12">
                    <input type="text" class="form-control"
                      name="celular" id="celular" placeholder="72345678" maxlength="20">
                  </div>
                </div>
                <div class="form-group row">
                  <h3 class="font-weight-bold text-info rounded">BIBLIOTECA</h3>
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
                          <th>ESTADO</th>
                          <th>MODIFICADO POR</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($Libros as $rowLibro)
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
                            <td class="font-weight-bold"><div class="{{helper_formatoClassLibroEstado($rowLibro->estado)}}">{{helper_FormatoAtributoValorATexto($rowLibro->estado, 'libroEstado')}}</div></td>
                            <td>{{helper_formatoNullorEmpty($rowLibro->correo)}}</td>
                            <td>
                              <div class="btn-group">
                                @if ($rowLibro->estado == 1)
                                <a class="btn btn-success anhadir-lista" data-id="{{$rowLibro->idLibro}}" data-codigo="{{$rowLibro->codigoLibro}}" data-titulo="{{$rowLibro->nombreLibro}}" data-autor="{{$rowLibro->nombreAutor}}">
                                  {!! helper_FormatoBotonCRUD(9 , 'icono') !!}
                                </a>
                                @endif           
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>        
                    </table>
                  </div>
                  <h3 class="font-weight-bold text-info rounded">LIBROS SELECCIONADOS</h3>
                  <div class="col-md-12">
                    <table id="prestamoLibroTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>CÓDIGO</th>
                          <th>TÍTULO</th>
                          <th>AUTOR</th>
                          <th>QUITAR</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>        
                    </table>
                  </div>
                </div>
                <div class="form-group row">
                  <h3 class="font-weight-bold text-info rounded">FECHA DE DEVOLUCIÓN</h3>
                  <div class="col-sm-12">
                    <input type="date" class="form-control @error('fechaDevolucion') is-invalid @enderror"
                      name="fechaDevolucion" id="fechaDevolucion" value="{{old('fechaDevolucion',date("Y-m-d", strtotime("+1 week")))}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12 d-flex align-items-center">
                    <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
                    <p>⠀</p>
                    <a href="{{route('librosprestamos.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
                    <p>⠀</p>
                    <div id="cargando" class="sk-chase">
                      <div class="sk-chase-dot"></div>
                      <div class="sk-chase-dot"></div>
                      <div class="sk-chase-dot"></div>
                      <div class="sk-chase-dot"></div>
                      <div class="sk-chase-dot"></div>
                      <div class="sk-chase-dot"></div>
                    </div>
                  </div>
                </div>
              </div>
              
              </form>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
@include('Layouts.footerStart')
@include('LibroPrestamo.createScripts')
@include('Layouts.footerEnd')