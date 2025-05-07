<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/bootstrapdompdf.css">

    <title>COMPROBANTE PRÉSTAMO DE LIBROS N° {{ $libroprestamo->idLibrosPrestamo }}</title>
</head>

<body>
    <style>
        html {
            margin: 15px;
        }
        body {
            font-size: 11px;
        }

        .page-break {
            page-break-after: always;
        }

        .table-container {
            display: flex;
            flex-direction: column;
        }

        .table-container table {
            margin: 0;
        }

        .table-container table td {
            padding: 0;
        }

        .inicio {
            margin: 0;
            padding: 0;
        }

        .background-image {
            position: absolute;
            top: 17;
            left: 59.9%;
            width: 40%;
            height: 28%;
            z-index: -1;
            opacity: 0.2;
            /* Ajusta la opacidad para simular un sello seco */
        }
    </style>
    @php
        $totalItems = count($detalles);
        $numeroBoleta = 1;
    @endphp
    @for ($i = 0; $i < $totalItems; $i += 3)
        <div class="border border-info p-1">
            <div class="table-container">
                <img src="{{ URL::to('/') }}/public/img/caff.jpeg" class="background-image">
                <table class="table inicio">
                    <tr style="text-align: center; border-style: hidden;">
                        <td width="10%"><img src="{{ URL::to('/') }}/public/img/caff.jpeg" width="100%"></td>
                        <td width="80%" class="font-weight-bold align-middle text-info">
                            COOPERATIVA EDUCACIONAL FEDERICO FROEBEL R.L.
                            <br>BIBLIOTECA/BIBLIOTHEK
                            <br>Boleta de Préstamo/Ausleihquittung N°
                            {{ $libroprestamo->idLibrosPrestamo }}{{ $totalItems > 3 ? '-' . $numeroBoleta . '/' . ceil($totalItems / 3) : '' }}
                        </td>
                        <td width="22.5%" class="font-weight-bold align-middle p-1" style="border-left: 1px dotted black;">
                            <div class="border border-dark">
                                Lector/Leser:<br>
                            {{ trim($persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres) }}
                            </div>
                        </td>
                    </tr>
                </table>
                <table class="table font-weight-bold">
                    <tr style="border-style: hidden;">
                        <td style="text-align: left;border-style: hidden; border-right: 1px dotted black;" colspan="2">Titulo/Titel:</td>
                        <td class="p-1" width="20%" rowspan="8" style="text-align: left; border-left: 1px dotted black;">
                            <span class="text-info">Boleta para Lector/Quittung für den Leser N° {{ $libroprestamo->idLibrosPrestamo }}{{ $totalItems > 3 ? '-' . $numeroBoleta . '/' . ceil($totalItems / 3) : '' }}</span>
                            <br>Préstamo hasta/Ausgeliehen bis:  {{ helper_formatoVistaFecha($libroprestamo->fechaDevolucion) }}
                            @for ($j = 0; $j < 3 && $i + $j < $totalItems; $j++)
                                <br>{{ $i + $j + 1 }}. <span class="text-info">{{ $detalles[$i + $j]->codigoLibro }}</span> <span style="font-weight: normal">{{ $detalles[$i + $j]->nombreLibro }}</span>
                            @endfor
                            @if ($i + 3 > $totalItems)
                                @for ($relleno = 0; $relleno < 3 - ($totalItems % 3); $relleno++)
                                    <br>{{ $i + $j + 1 }}. N/A <br>
                                    @php
                                        $j++;
                                    @endphp
                                @endfor
                            @endif
                        </td>
                    </tr>
                    @for ($j = 0; $j < 3 && $i + $j < $totalItems; $j++)
                        <tr style="border-style: hidden;">
                            <td style="text-align: left;" width="66%" colspan="2">{{ $i + $j + 1 }}. <span class="text-info">{{ $detalles[$i + $j]->codigoLibro }}</span> <span
                                    style="font-weight: normal;">{{ $detalles[$i + $j]->nombreLibro }}</span>
                            </td>
                        </tr>
                    @endfor
                    @if ($i + 3 > $totalItems)
                        @for ($relleno = 0; $relleno < 3 - ($totalItems % 3); $relleno++)
                            <tr style="border-style: hidden;">
                                <td colspan="2">{{ $i + $j + 1 }}. N/A</td>
                            </tr>
                            @php
                                $j++;
                            @endphp
                        @endfor
                    @endif
                    <tr style="border-style: hidden;">
                        <td style="text-align: left;">Lector/Leser: <span
                                style="font-weight: normal;">{{ trim('(' . $persona->tipoPerfil . ') ' . $persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres) }}</span>
                        </td>
                        <td style="text-align: left;border-style: hidden; border-right: 1px dotted black;">Celular/Handynummer: <span style="font-weight: normal;">{{$libroprestamo->celular}}</span></td>
                    </tr>
                    <tr style="border-style: hidden;">
                        <td style="text-align: left;">Fecha/Datum: <span
                                style="font-weight: normal;">{{ helper_formatoVistaFechayHora($libroprestamo->fechaRegistro) }}</span>
                                <br>Curso/Klasse: <span style="font-weight: normal;">{{ $libroprestamo->nombreCurso }}</span>
                        </td>
                        <td rowspan="3" class="p-1" style="text-align: left;border-style: hidden; border-right: 1px dotted black;">
                            <div class="border border-dark p-1">
                                @for ($j = 0; $j < 3 && $i + $j < $totalItems; $j++)
                                    {{ $i + $j + 1 }}: {{$detalles[$i + $j]->fechaRetorno ? '¡Retornado el ' . helper_formatoVistaFechayHora($detalles[$i + $j]->fechaRetorno) . '!' : ''}}<br><br>
                                @endfor
                                @if ($i + 3 > $totalItems)
                                    @for ($relleno = 0; $relleno < 3 - ($totalItems % 3); $relleno++)
                                        {{ $i + $j + 1 }}: N/A<br><br>
                                        @php
                                            $j++;
                                        @endphp
                                    @endfor
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr style="border-style: hidden;">
                        <td style="text-align: left;">Fecha de Devolución/Rückgabedatum: <span
                                style="font-weight: normal;">{{ helper_formatoVistaFecha($libroprestamo->fechaDevolucion) }}</span>
                        </td>
                    </tr>
                    <tr style="border-style: hidden;">
                        <td style="text-align: center;">
                            <br>_____________________<br>Firma/Unterschrift
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <br><br>
        @php
            $numeroBoleta++;
        @endphp
        @if ($i + 3 < $totalItems)
            <div class="page-break"></div>
        @endif
    @endfor
</body>

</html>
