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
            <li class="breadcrumb-item active">REPORTES (BIBLIOTECA)</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    @php
      $index = 1;
    @endphp
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title font-weight-bold">REPORTES (BIBLIOTECA)</h3>
      </div>
      <div class="card-body">
        <!-- Formulario de búsqueda -->
        <form method="GET">
          <div class="input-group input-group-sm col-md-6 align-items-center">
            <label for="fechaInicio" class="col-form-label">Fecha Inicio:&nbsp;</label>
            <input type="date" name="fechaInicio" class="form-control" value="{{$fechaInicio}}">
            &nbsp;
            <label for="fechaFin" class="col-form-label">Fecha Fin:&nbsp;</label>
            <input type="date" name="fechaFin" class="form-control" value="{{$fechaFin}}">
            &nbsp;
            <button type="submit" formaction="{{route('librosprestamos.reports')}}" class="btn btn-info btn-flat rounded">{!! helper_FormatoBotonCRUD(8, 'texto') !!}</button>
            &nbsp;
            <button type="submit" formaction="{{route('librosprestamos.reports.pdf')}}" class="btn btn-dark btn-flat rounded">{!! helper_FormatoBotonCRUD(12, 'texto') !!}</button>
            </span>
          </div>
        </form>
        <br>
        @if($errors->any())
          <div class="alert alert-warning col-md-6">
            <h5 class="font font-weight-bold"><i class="icon fa fa-warning"></i> ¡ATENCIÓN!</h5>
            <ul>
              @foreach($errors->all() as $error)
                <li class="font-weight-bold">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        @if ($fechaInicio)
          <h3 class="font-weight-bold">
            Resultados de la búsqueda entre <span class="text-info">{{date('d/m/Y', strtotime($fechaInicio))}}</span> y <span class="text-info">{{date('d/m/Y', strtotime($fechaFin))}}</span>:
          </h3>
          <br>
        @endif
          <div class="alert alert-info col-md-6">
            <h3 class="font-weight-bold"><i class="icon fa fa-book"></i>CANTIDAD TOTAL DE LIBROS PRESTADOS: {{ $countLibrosPrestados }}</h3>
          </div>
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12 border border-info rounded p-1 m-1">
        <h3 class="font-weight-bold text-info ml-2">INDICE</h3>
        <ul class="font-weight-bold">
            <li><u><a class="text-dark" href="#detalle">1. DETALLE</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-general">2. CANTIDAD DE LIBROS PRESTADOS EN GENERAL</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-primaria">3. CANTIDAD DE LIBROS PRESTADOS POR NIVEL (PRIMARIA)</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-secundaria">4. CANTIDAD DE LIBROS PRESTADOS POR NIVEL (SECUNDARIA)</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-otros">5. CANTIDAD DE LIBROS PRESTADOS A OTROS</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-persona">6. CANTIDAD DE LIBROS PRESTADOS POR PERSONA</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-libro">7. CANTIDAD DE LIBROS PRESTADOS, AGRUPADOS POR LIBRO</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-categoria">8. CANTIDAD DE LIBROS PRESTADOS, AGRUPADOS POR CATEGORIA</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-general-deuda-persona">9. CANTIDAD TOTAL GENERAL DE LIBROS ADEUDADOS, AGRUPADOS POR PERSONA</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-total-general-persona">10. CANTIDAD TOTAL GENERAL DE LIBROS PRESTADOS Y ADEUDADOS, AGRUPADOS POR PERSONA</a></u></li>
        </ul>
    </div>
          <div class="col-md-12">
            <br><br>
            <h3 class="font-weight-bold text-info" id="detalle"><u>1. DETALLE:</u></h3>
            <table class="table table-bordered table-striped" id="dataTable-detalle">
              <thead>
                <tr>
                  <th>N° PRESTAMO</th>
                  <th>CODIGO LIBRO</th>
                  <th>TITULO</th>
                  <th>AUTOR</th>
                  <th>EDITORIAL</th>
                  <th>PRESTADO A</th>
                  <th>CURSO</th>
                  <th>F. REGISTRO</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($LibrosPrestadosDetalle as $rowLibro)
                  <tr>
                    <td>{{ $rowLibro->idLibrosPrestamo }}</td>
                    <td>{{ $rowLibro->codigoLibro }}</td>
                    <td>{{ $rowLibro->nombreLibro }}</td>
                    <td>{{ $rowLibro->nombreAutor }}</td>
                    <td>{{ $rowLibro->nombreEditorial }}</td>
                    <td>{{ trim($rowLibro->apellidoPaterno . ' ' . $rowLibro->apellidoMaterno . ' ' . $rowLibro->nombres) }}</td>
                    <td>{{ $rowLibro->nombreCurso }}</td>
                    <td>{{ helper_formatoVistaFecha($rowLibro->fechaRegistro) }}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('libros.details', $rowLibro->idLibro)}}" target="_blank" rel="noopener noreferrer">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-general"><u>2. CANTIDAD DE LIBROS PRESTADOS EN GENERAL</u></h3>
            @if (!$LibrosPrestadosCantidadGeneral->isEmpty())
            <table class="table table-bordered table-striped" id="dataTable-cantidad-general">
              <thead>
                <tr class="text-center">
                  <th>N°</th>
                  <th>CURSO</th>
                  <th>CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($LibrosPrestadosCantidadGeneral as $rowPrimaria)
                  <tr>
                    <td class="font-weight-bold text-center">{{$index}}</td>
                    <td>{{$rowPrimaria->nombreCurso}}</td>
                    <td class="text-center">{{$rowPrimaria->totalLibrosPrestados}}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @php
                  $index = 1;
                @endphp
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total de libros prestados (General, agrupados por curso): <span class="text-info">{{ $LibrosPrestadosCantidadGeneral->sum('totalLibrosPrestados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif

            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-primaria"><u>3. CANTIDAD DE LIBROS PRESTADOS POR NIVEL (PRIMARIA)</u></h3>
            @if (!$LibrosPrestadosCantidadNivelPrimaria->isEmpty())
            <table class="table table-bordered table-striped" id="dataTable-cantidad-primaria">
              <thead>
                <tr class="text-center">
                  <th>N°</th>
                  <th>CURSO</th>
                  <th>CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($LibrosPrestadosCantidadNivelPrimaria as $rowPrimaria)
                  <tr>
                    <td class="font-weight-bold text-center">{{$index}}</td>
                    <td>{{$rowPrimaria->nombreCurso}}</td>
                    <td class="text-center">{{$rowPrimaria->totalLibrosPrestados}}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @php
                  $index = 1;
                @endphp
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total de libros prestados (Primaria, agrupados por curso): <span class="text-info">{{ $LibrosPrestadosCantidadNivelPrimaria->sum('totalLibrosPrestados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif
            
            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-secundaria"><u>4. CANTIDAD DE LIBROS PRESTADOS POR NIVEL (SECUNDARIA)</u></h3>
            @if (!$LibrosPrestadosCantidadNivelSecundaria->isEmpty())
            
            <table class="table table-bordered table-striped" id="dataTable-cantidad-secundaria">
              <thead>
                <tr class="text-center">
                  <th>N°</th>
                  <th>CURSO</th>
                  <th>CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($LibrosPrestadosCantidadNivelSecundaria as $rowSecundaria)
                  <tr>
                    <td class="font-weight-bold text-center">{{$index}}</td>
                    <td>{{$rowSecundaria->nombreCurso}}</td>
                    <td class="text-center">{{$rowSecundaria->totalLibrosPrestados}}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @php
                  $index = 1;
                @endphp
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total de libros prestados (Secundaria, agrupados por curso): <span class="text-info">{{ $LibrosPrestadosCantidadNivelSecundaria->sum('totalLibrosPrestados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif

            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-otros"><u>5. CANTIDAD DE LIBROS PRESTADOS A OTROS</u></h3>
            @if (!$LibrosPrestadosCantidadPorOtros->isEmpty())
            
            <table class="table table-bordered table-striped" id="dataTable-cantidad-otros">
              <thead>
                <tr class="text-center">
                  <th>OTROS</th>
                  <th>CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($LibrosPrestadosCantidadPorOtros as $rowOtros)
                  <tr>
                    <td>{{$rowOtros->nombreCurso}}</td>
                    <td class="text-center">{{$rowOtros->totalLibrosPrestados}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total de libros prestados (Otros): <span class="text-info">{{ $LibrosPrestadosCantidadPorOtros->sum('totalLibrosPrestados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif
            
            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-persona"><u>6. CANTIDAD DE LIBROS PRESTADOS POR PERSONA</u></h3>
            @if (!$LibrosPrestadosAgrupadosPorPersona->isEmpty())
            
            <table class="table table-bordered table-striped" id="dataTable-cantidad-persona">
              <thead>
                <tr class="text-center">
                  <th>N°</th>
                  <th>PERFIL</th>
                  <th>CURSO</th>
                  <th>NOMBRE</th>
                  <th>CANT. LIBROS PRESTADOS</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($LibrosPrestadosAgrupadosPorPersona as $rowPersona)
                  <tr>
                    <td class="font-weight-bold text-center">{{$index}}</td>
                    <td>{{$rowPersona->tipoPerfil}}</td>
                    <td>{{$rowPersona->nombreCurso}}</td>
                    <td>{{trim($rowPersona->apellidoPaterno . ' ' . $rowPersona->apellidoMaterno . ' ' . $rowPersona->nombres)}}</td>
                    <td class="text-center">{{$rowPersona->totalLibrosPrestados}}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @php
                  $index = 1;
                @endphp
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total de libros prestados (Agrupados por persona): <span class="text-info">{{ $LibrosPrestadosAgrupadosPorPersona->sum('totalLibrosPrestados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif

            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-libro"><u>7. CANTIDAD DE LIBROS PRESTADOS, AGRUPADOS POR LIBRO</u></h3>
            @if (!$LibrosPrestadosAgrupadosPorLibro->isEmpty())
            
            <table class="table table-bordered table-striped" id="dataTable-cantidad-libro">
              <thead>
                <tr class="text-center">
                  <th>N°</th>
                  <th>LIBRO</th>
                  <th>CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($LibrosPrestadosAgrupadosPorLibro as $rowLibro)
                  <tr>
                    <td class="font-weight-bold text-center">{{$index}}</td>
                    <td>{{$rowLibro->codigoLibro . ' - ' . $rowLibro->nombreLibro}}</td>
                    <td class="text-center">{{$rowLibro->totalLibrosPrestados}}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @php
                  $index = 1;
                @endphp
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total de libros prestados (Agrupados por libro): <span class="text-info">{{ $LibrosPrestadosAgrupadosPorLibro->sum('totalLibrosPrestados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif

            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-categoria"><u>8. CANTIDAD DE LIBROS PRESTADOS, AGRUPADOS POR CATEGORIA</u></h3>
            @if (!$LibrosPrestadosAgrupadosPorCategoria->isEmpty())
            
            <table class="table table-bordered table-striped" id="dataTable-cantidad-categoria">
              <thead>
                <tr class="text-center">
                  <th>N°</th>
                  <th>CATEGORIA</th>
                  <th>CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($LibrosPrestadosAgrupadosPorCategoria as $rowCategoria)
                  <tr>
                    <td class="font-weight-bold text-center">{{$index}}</td>
                    <td>{{$rowCategoria->nombreCategoria}}</td>
                    <td class="text-center">{{$rowCategoria->totalLibrosPrestados}}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @php
                  $index = 1;
                @endphp
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total de libros prestados (Agrupados por categoria): <span class="text-info">{{ $LibrosPrestadosAgrupadosPorCategoria->sum('totalLibrosPrestados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif

            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-general-deuda-persona"><u>9. CANTIDAD TOTAL GENERAL DE LIBROS ADEUDADOS, AGRUPADOS POR PERSONA</u></h3>
            @if (!$LibrosAdeudadosAgrupadosPorPersona->isEmpty())
            
            <table class="table table-bordered table-striped" id="dataTable-cantidad-general-deuda-persona">
              <thead>
                <tr class="text-center">
                  <th>N°</th>
                  <th>PERFIL</th>
                  <th>CURSO</th>
                  <th>PERSONA</th>
                  <th>CANT.</th>
                  <th>LIBROS ADEUDADOS</th>
                  <th>F. PRESTAMOS</th>
                  <th>DIAS DE RETRASO</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($LibrosAdeudadosAgrupadosPorPersona as $rowDeudaPersona)
                  <tr>
                    <td class="font-weight-bold text-center">{{$index}}</td>
                    <td>{{$rowDeudaPersona->tipoPerfil}}</td>
                    <td>{{helper_abreviarCurso($rowDeudaPersona->nombreCurso)}}</td>
                    <td>{{trim($rowDeudaPersona->apellidoPaterno . ' ' . $rowDeudaPersona->apellidoMaterno . ' ' . $rowDeudaPersona->nombres)}}</td>
                    <td class="text-center">{{$rowDeudaPersona->totalLibrosAdeudados}}</td>
                    <td>{!! $rowDeudaPersona->librosAdeudados !!}</td>
                    <td>{!! $rowDeudaPersona->fechasPrestamos !!}</td>
                    <td>{!! $rowDeudaPersona->diasRetraso !!}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @php
                  $index = 1;
                @endphp
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total general de libros adeudados hasta el presente (Agrupados por persona): <span class="text-info">{{ $LibrosAdeudadosAgrupadosPorPersona->sum('totalLibrosAdeudados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif

            <br><br>
            <h3 class="font-weight-bold text-info" id="cantidad-total-general-persona"><u>10. CANTIDAD TOTAL GENERAL DE LIBROS PRESTADOS Y ADEUDADOS, AGRUPADOS POR PERSONA</u></h3>
            @if (!$TotalGeneralLibrosPrestadosAgrupadosPorPersona->isEmpty())
            
            <table class="table table-bordered table-striped" id="dataTable-cantidad-total-general-persona">
              <thead>
                <tr class="text-center">
                  <th>N°</th>
                  <th>PERFIL</th>
                  <th>CURSO</th>
                  <th>PERSONA</th>
                  <th>T. G. LIBROS PRESTADOS</th>
                  <th>T. G. LIBROS ADEUDADOS</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($TotalGeneralLibrosPrestadosAgrupadosPorPersona as $rowTotalGeneralLibrosPrestados)
                  <tr>
                    <td class="font-weight-bold text-center">{{$index}}</td>
                    <td>{{$rowTotalGeneralLibrosPrestados->tipoPerfil}}</td>
                    <td>{{helper_abreviarCurso($rowTotalGeneralLibrosPrestados->nombreCurso)}}</td>
                    <td>{{trim($rowTotalGeneralLibrosPrestados->apellidoPaterno . ' ' . $rowTotalGeneralLibrosPrestados->apellidoMaterno . ' ' . $rowTotalGeneralLibrosPrestados->nombres)}}</td>
                    <td class="text-center">{{$rowTotalGeneralLibrosPrestados->totalLibrosPrestados}}</td>
                    <td class="text-center">{{$rowTotalGeneralLibrosPrestados->totalLibrosAdeudados}}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @php
                  $index = 1;
                @endphp
              </tbody>
            </table>
            <p class="font-weight-bold">Cant. Total general de libros prestados y adeudados hasta el presente (Agrupados por personas ACTIVAS): <span class="text-info">{{ $TotalGeneralLibrosPrestadosAgrupadosPorPersona->sum('totalLibrosPrestados') }}</span> y <span class="text-info">{{ $TotalGeneralLibrosPrestadosAgrupadosPorPersona->sum('totalLibrosAdeudados') }}</span></p>
            @else
            <p class="font-weight-bold">No se encontraron registros :(</p>
            @endif
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->
@include('Layouts.footerStart')
@include('LibroPrestamo.reporteScripts')
@include('Layouts.footerEnd')