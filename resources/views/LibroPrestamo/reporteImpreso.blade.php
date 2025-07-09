<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{public_path('bootstrapdompdf.css')}}">

    <title>REPORTE DE PRÉSTAMOS DE LIBROS ENTRE {{ date('d/m/Y', strtotime($fechaInicio)) }} Y
        {{ date('d/m/Y', strtotime($fechaFin)) }}</title>
</head>

<body>
    <style>
        html {
            margin: 25px;
        }

        body {
            font-size: 11px;
            position: relative;
        }

        .page-break {
            page-break-after: always;
        }

        .table-container {
            display: flex;
            flex-direction: column;
        }

        .tabla-inicio table {
            margin: 0;
        }

        .tabla-inicio table td {
            padding: 0;
        }

        .tabla-relleno-corto {
            margin-bottom: 1rem;
        }
        .tabla-relleno-corto table td {
            padding: 0;
        }

        .inicio {
            margin: 0;
            padding: 0;
        }

        .watermark {
            position: fixed;
            top: 34.5%;
            left: 28%;
            width: 300px;
            opacity: 0.15;
            z-index: -1000;
        }

        .subtitulo {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
    <img src="{{public_path('img/ceff.jpg')}}" class="watermark">
    @php
        $index = 1;
    @endphp
    <div class="d-flex justify-content-center">
        <table class="tabla-inicio">
            <tr>
                <td width="25%"><img src="{{public_path('img/ceff.jpg')}}" width="30%"></td>
                <td width="50%" class="align-middle text-center font-weight-bold">
                    <p class="inicio" style="font-size: 25px">REPORTE DE BIBLIOTECA</p>
                    <p>Préstamos de libros efectuados entre fechas: <span
                            class="text-info">{{ date('d/m/Y', strtotime($fechaInicio)) }}</span> a <span
                            class="text-info">{{ date('d/m/Y', strtotime($fechaFin)) }}</span>
                </td>
                <td width="25%"></td>
            </tr>
        </table>
    </div>

    <p class="align-middle border border-info rounded p-1 font-weight-bold">Fecha de creación: <span class="text-info align-middle">{{ date('d/m/Y h:i:s') }}</span>, generado por: <span class="text-info align-middle">{{ session('correo') }}</span></p>

    <p class="subtitulo bg-info text-white p-1 text-center rounded align-middle">CANTIDAD TOTAL DE LIBROS PRESTADOS:
        {{ $countLibrosPrestados }}</p>

    <div class="border border-info rounded p-1">
        <p class="subtitulo text-info ml-2">INDICE</p>
        <ul class="subtitulo">
            <li><u><a class="text-dark" href="#detalle">1. DETALLE</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-general">2. CANTIDAD DE LIBROS PRESTADOS EN GENERAL</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-primaria">3. CANTIDAD DE LIBROS PRESTADOS POR NIVEL
                        (PRIMARIA)</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-secundaria">4. CANTIDAD DE LIBROS PRESTADOS POR NIVEL
                        (SECUNDARIA)</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-otros">5. CANTIDAD DE LIBROS PRESTADOS A OTROS</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-persona">6. CANTIDAD DE LIBROS PRESTADOS POR PERSONA</a></u>
            </li>
            <li><u><a class="text-dark" href="#cantidad-libro">7. CANTIDAD DE LIBROS PRESTADOS, AGRUPADOS POR
                        LIBRO</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-categoria">8. CANTIDAD DE LIBROS PRESTADOS, AGRUPADOS POR
                        CATEGORIA</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-general-deuda-persona">9. CANTIDAD GENERAL DE LIBROS ADEUDADOS, AGRUPADOS POR
                        PERSONA</a></u></li>
            <li><u><a class="text-dark" href="#cantidad-total-general-persona">10. CANTIDAD TOTAL GENERAL DE LIBROS PRESTADOS Y ADEUDADOS, AGRUPADOS POR PERSONA</a></u></li>
        </ul>
    </div>

    <div class="page-break"></div>


    <p class="subtitulo text-info" id="detalle"><u>1. DETALLE</u></p>
    @if (count($LibrosPrestadosDetalle) > 0)
        <table class="table table-bordered table-striped table-sm">
            <thead class="bg-secondary text-light font-weight-bold text-center">
                <tr>
                    <th class="align-middle">N° L</th>
                    <th class="align-middle">N° P</th>
                    <th class="align-middle">CODIGO LIBRO</th>
                    <th class="align-middle">TITULO</th>
                    <th class="align-middle">AUTOR</th>
                    <th class="align-middle">EDITORIAL</th>
                    <th class="align-middle">PRESTADO A</th>
                    <th class="align-middle">CURSO</th>
                    <th class="align-middle">F. REGISTRO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LibrosPrestadosDetalle as $rowLibro)
                    <tr>
                        <td class="text-center font-weight-bold text-info">{{ $index }}</td>
                        <td class="text-center font-weight-bold">{{ $rowLibro->idLibrosPrestamo }}</td>
                        <td>{{ $rowLibro->codigoLibro }}</td>
                        <td>{{ $rowLibro->nombreLibro }}</td>
                        <td>{{ $rowLibro->nombreAutor }}</td>
                        <td>{{ $rowLibro->nombreEditorial }}</td>
                        <td>{{ trim($rowLibro->apellidoPaterno . ' ' . $rowLibro->apellidoMaterno . ' ' . $rowLibro->nombres) }}
                        </td>
                        <td>{{ $rowLibro->nombreCurso }}</td>
                        <td>{{ helper_formatoVistaFechayHora($rowLibro->fechaRegistro) }}</td>
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
        <p class="font-weight-bold">Cant. Total de libros prestados (General): <span
                class="text-info">{{ count($LibrosPrestadosDetalle) }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    <div class="page-break"></div>

    <p class="subtitulo text-info" id="cantidad-general"><u>2. CANTIDAD DE LIBROS PRESTADOS EN GENERAL</u></p>
    @if (count($LibrosPrestadosCantidadGeneral) > 0)
        <table class="table-bordered table-striped tabla-relleno-corto col-12">
            <thead class="bg-secondary text-light">
                <tr class="text-center">
                    <th>N°</th>
                    <th>CURSO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LibrosPrestadosCantidadGeneral as $rowPrimaria)
                    <tr>
                        <td class="font-weight-bold text-center">{{ $index }}</td>
                        <td>{{ $rowPrimaria->nombreCurso }}</td>
                        <td class="text-center">{{ $rowPrimaria->totalLibrosPrestados }}</td>
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
        <p class="font-weight-bold">Cant. Total de libros prestados (General, agrupados por curso): <span
                class="text-info">{{ $LibrosPrestadosCantidadGeneral->sum('totalLibrosPrestados') }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    @if (count($LibrosPrestadosCantidadNivelPrimaria) > 0)
        <div class="page-break"></div>
    @endif

    <p class="subtitulo text-info" id="cantidad-primaria"><u>3. CANTIDAD DE LIBROS PRESTADOS POR NIVEL (PRIMARIA)</u>
    </p>
    @if (count($LibrosPrestadosCantidadNivelPrimaria) > 0)
        <table class="table table-bordered table-striped">
            <thead class="bg-secondary text-light">
                <tr class="text-center">
                    <th>N°</th>
                    <th>CURSO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LibrosPrestadosCantidadNivelPrimaria as $rowPrimaria)
                    <tr>
                        <td class="font-weight-bold text-center">{{ $index }}</td>
                        <td>{{ $rowPrimaria->nombreCurso }}</td>
                        <td class="text-center">{{ $rowPrimaria->totalLibrosPrestados }}</td>
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
        <p class="font-weight-bold">Cant. Total de libros prestados (Primaria, agrupados por curso): <span
                class="text-info">{{ $LibrosPrestadosCantidadNivelPrimaria->sum('totalLibrosPrestados') }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    @if (count($LibrosPrestadosCantidadNivelSecundaria) > 0)
        <div class="page-break"></div>
    @endif

    <p class="subtitulo text-info" id="cantidad-secundaria"><u>4. CANTIDAD DE LIBROS PRESTADOS POR NIVEL
            (SECUNDARIA)</u></p>
    @if (count($LibrosPrestadosCantidadNivelSecundaria) > 0)
        <table class="table table-bordered table-striped">
            <thead class="bg-secondary text-light">
                <tr class="text-center">
                    <th>N°</th>
                    <th>CURSO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LibrosPrestadosCantidadNivelSecundaria as $rowSecundaria)
                    <tr>
                        <td class="font-weight-bold text-center">{{ $index }}</td>
                        <td>{{ $rowSecundaria->nombreCurso }}</td>
                        <td class="text-center">{{ $rowSecundaria->totalLibrosPrestados }}</td>
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
        <p class="font-weight-bold">Cant. Total de libros prestados (Secundaria, agrupados por curso): <span
                class="text-info">{{ $LibrosPrestadosCantidadNivelSecundaria->sum('totalLibrosPrestados') }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    @if (count($LibrosPrestadosCantidadPorOtros) > 0)
        <div class="page-break"></div>
    @endif

    <p class="subtitulo text-info" id="cantidad-otros"><u>5. CANTIDAD DE LIBROS PRESTADOS A OTROS</u></p>
    @if (count($LibrosPrestadosCantidadPorOtros) > 0)
        <table class="table table-bordered table-striped">
            <thead class="bg-secondary text-light">
                <tr class="text-center">
                    <th>OTROS</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LibrosPrestadosCantidadPorOtros as $rowOtros)
                    <tr>
                        <td>{{ $rowOtros->nombreCurso }}</td>
                        <td class="text-center">{{ $rowOtros->totalLibrosPrestados }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="font-weight-bold">Cant. Total de libros prestados (Otros): <span
                class="text-info">{{ $LibrosPrestadosCantidadPorOtros->sum('totalLibrosPrestados') }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    <div class="page-break"></div>

    <p class="subtitulo text-info" id="cantidad-persona"><u>6. CANTIDAD DE LIBROS PRESTADOS POR PERSONA</u></p>
    @if (count($LibrosPrestadosAgrupadosPorPersona) > 0)
        <table class="table-bordered table-striped tabla-relleno-corto col-12">
            <thead class="bg-secondary text-light">
                <tr class="text-center">
                    <th>N°</th>
                    <th>PERFIL</th>
                    <th>CURSO</th>
                    <th>NOMBRE</th>
                    <th>CANT.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LibrosPrestadosAgrupadosPorPersona as $rowPersona)
                    <tr>
                        <td class="font-weight-bold text-center">{{ $index }}</td>
                        <td>{{ $rowPersona->tipoPerfil }}</td>
                        <td>{{ $rowPersona->nombreCurso }}</td>
                        <td>{{ trim($rowPersona->apellidoPaterno . ' ' . $rowPersona->apellidoMaterno . ' ' . $rowPersona->nombres) }}
                        </td>
                        <td class="text-center">{{ $rowPersona->totalLibrosPrestados }}</td>
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
        <p class="font-weight-bold">Cant. Total de libros prestados (Agrupados por persona): <span
                class="text-info">{{ $LibrosPrestadosAgrupadosPorPersona->sum('totalLibrosPrestados') }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    <div class="page-break"></div>

    <p class="subtitulo text-info" id="cantidad-libro"><u>7. CANTIDAD DE LIBROS PRESTADOS, AGRUPADOS POR LIBRO</u></p>
    @if (count($LibrosPrestadosAgrupadosPorLibro) > 0)
        <table class="table-bordered table-striped tabla-relleno-corto col-12">
            <thead class="bg-secondary text-light">
                <tr class="text-center">
                    <th>N°</th>
                    <th>LIBRO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LibrosPrestadosAgrupadosPorLibro as $rowLibro)
                    <tr>
                        <td class="font-weight-bold text-center">{{ $index }}</td>
                        <td>{{ $rowLibro->codigoLibro . ' - ' . $rowLibro->nombreLibro }}</td>
                        <td class="text-center">{{ $rowLibro->totalLibrosPrestados }}</td>
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
        <p class="font-weight-bold">Cant. Total de libros prestados (Agrupados por libro): <span
                class="text-info">{{ $LibrosPrestadosAgrupadosPorLibro->sum('totalLibrosPrestados') }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    <div class="page-break"></div>

    <p class="subtitulo text-info" id="cantidad-categoria"><u>8. CANTIDAD DE LIBROS PRESTADOS, AGRUPADOS POR
            CATEGORIA</u></p>
    @if (count($LibrosPrestadosAgrupadosPorCategoria) > 0)
        <table class="table table-bordered table-striped">
            <thead class="bg-secondary text-light">
                <tr class="text-center">
                    <th>N°</th>
                    <th>CATEGORIA</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LibrosPrestadosAgrupadosPorCategoria as $rowCategoria)
                    <tr>
                        <td class="font-weight-bold text-center">{{ $index }}</td>
                        <td>{{ $rowCategoria->nombreCategoria }}</td>
                        <td class="text-center">{{ $rowCategoria->totalLibrosPrestados }}</td>
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
        <p class="font-weight-bold">Cant. Total de libros prestados (Agrupados por categoria): <span
                class="text-info">{{ $LibrosPrestadosAgrupadosPorCategoria->sum('totalLibrosPrestados') }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    <div class="page-break"></div>

    <p class="subtitulo text-info" id="cantidad-general-deuda-persona"><u>9. CANTIDAD GENERAL DE LIBROS ADEUDADOS, AGRUPADOS POR PERSONA</u></p>
    @if (count($LibrosAdeudadosAgrupadosPorPersona) > 0)
        <table class="table-bordered table-striped tabla-relleno-corto col-12">
            <thead class="bg-secondary text-light">
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
                        <td class="font-weight-bold text-center">{{ $index }}</td>
                        <td>{{ $rowDeudaPersona->tipoPerfil }}</td>
                        <td class="text-center">{{ helper_abreviarCurso($rowDeudaPersona->nombreCurso) }}</td>
                        <td>{{ trim($rowDeudaPersona->apellidoPaterno . ' ' . $rowDeudaPersona->apellidoMaterno . ' ' . $rowDeudaPersona->nombres) }}
                        </td>
                        <td class="text-center">{{ $rowDeudaPersona->totalLibrosAdeudados }}</td>
                        <td>{!! $rowDeudaPersona->librosAdeudados !!}</td>
                        <td class="text-center">{!! $rowDeudaPersona->fechasPrestamos !!}</td>
                        <td class="text-center">{!! $rowDeudaPersona->diasRetraso !!}</td>
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
        <p class="font-weight-bold">Cant. Total general de libros adeudados hasta el presente (Agrupados por persona): <span
                class="text-info">{{ $LibrosAdeudadosAgrupadosPorPersona->sum('totalLibrosAdeudados') }}</span></p>
    @else
        <p class="font-weight-bold">No se encontraron registros :(</p>
    @endif

    <div class="page-break"></div>

    <p class="subtitulo text-info" id="cantidad-total-general-persona"><u>10. CANTIDAD TOTAL GENERAL DE LIBROS PRESTADOS Y ADEUDADOS, AGRUPADOS POR PERSONA</u></p>
    @if (count($TotalGeneralLibrosPrestadosAgrupadosPorPersona) > 0)
        <table class="table-bordered table-striped tabla-relleno-corto col-12">
            <thead class="bg-secondary text-light">
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

    <script type="text/php">
        if (isset($pdf)) {
        $pdf->page_script('
            $text = sprintf(_("- Página %d de %d -"),  $PAGE_NUM, $PAGE_COUNT);
            // Descomentar la siguiente línea si se desea usar un texto personalizado
            //$text = __("Page :pageNum/:pageCount", ["pageNum" => $PAGE_NUM, "pageCount" => $PAGE_COUNT]);
            $font = $fontMetrics->get_font("helvetica", "normal");
            $size = 9;
            $color = array(0,0,0);
            $word_space = 0.0;  //default
            $char_space = 0.0;  //default
            $angle = 0.0;   //default

            // Obtener las métricas de la fuente para calcular el ancho del texto
            $textWidth = $fontMetrics->getTextWidth($text, $font, $size);

            $x = ($pdf->get_width() - $textWidth) / 2;
            $y = $pdf->get_height() - 25;

            $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        ');
    }
    </script>
</body>

</html>
