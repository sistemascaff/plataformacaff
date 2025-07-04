@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold">{{ $asignatura->nombreAsignatura }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('asignaturas.index') }}">ASIGNATURAS</a></li>
                        <li class="breadcrumb-item active">{{ $asignatura->nombreAsignatura }}</li>
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
                    <a class="btn btn-info" href="{{ route('asignaturas.index') }}">
                        {!! helper_FormatoBotonCRUD(7, 'texto') !!}
                    </a>
                    <a class="btn btn-warning" href="{{ route('asignaturas.edit', $asignatura->idAsignatura) }}">
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
                            <label for="inputEmail3" class="col-md-2 col-form-label">Asignatura</label>
                            <div class="col-md-10">
                                <p class="form form-control">{{ $asignatura->nombreAsignatura }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Abreviatura</label>
                            <div class="col-md-10">
                                <p class="form form-control">{{ $asignatura->nombreCorto }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Tipo de Calificación</label>
                            <div class="col-md-10">
                                <p class="form form-control">
                                    {{ helper_FormatoAtributoValorATexto($asignatura->tipoCalificacion, 'asignaturaTipoCalificacion') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Tipo de Bloque</label>
                            <div class="col-md-10">
                                <p class="form form-control">
                                    {{ helper_FormatoAtributoValorATexto($asignatura->tipoBloque, 'asignaturaTipoBloque') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Tipo de Asignatura</label>
                            <div class="col-md-10">
                                <p class="form form-control">
                                    {{ helper_FormatoAtributoValorATexto($asignatura->tipoAsignatura, 'asignaturaTipoAsignatura') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Materia</label>
                            <div class="col-md-10">
                                <a href="{{ route('materias.details', $materia->idMateria) }}"
                                    class="form form-control font-weight-bold">{{ $materia->nombreMateria }}</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Coordinación</label>
                            <div class="col-md-10">
                                <p class="form form-control">
                                    {{ helper_formatoNullorEmpty($coordinacion->nombreCoordinacion) }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Aula</label>
                            <div class="col-md-10">
                                <a href="{{ route('aulas.details', $aula->idAula) }}"
                                    class="form form-control font-weight-bold">{{ $aula->nombreAula }}</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Docente</label>
                            <div class="col-md-10">
                                <a href="{{ route('docentes.details', $docente->idDocente) }}"
                                    class="form form-control font-weight-bold">{{ $persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres }}</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
                            <div class="col-md-10">
                                <p class="form form-control">{{ $asignatura->fechaRegistro }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
                            <div class="col-md-10">
                                <p class="form form-control">
                                    {{ helper_formatoNullorEmpty($asignatura->fechaActualizacion) }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Actualizado por</label>
                            <div class="col-md-10">
                                <p class="form form-control">{{ helper_formatoNullorEmpty($usuario->correo) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card card-info card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-1-tab" data-toggle="pill"
                                        href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1"
                                        aria-selected="true">Estudiantes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-2-tab" data-toggle="pill"
                                        href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2"
                                        aria-selected="false">Lista de Materiales</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-3-tab" data-toggle="pill"
                                        href="#custom-tabs-3" role="tab" aria-controls="custom-tabs-3"
                                        aria-selected="false">Horarios</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-4-tab" data-toggle="pill"
                                        href="#custom-tabs-4" role="tab" aria-controls="custom-tabs-4"
                                        aria-selected="false">Unidades y Sílabos</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-1" role="tabpanel"
                                    aria-labelledby="custom-tabs-1-tab">
                                    <h3 class="font-weight-bold text-info">ESTUDIANTES</h3>

                                    @if ($asignatura->tipoBloque == '2')
                                        <!-- Formulario para seleccionar un estudiante y añadirlo a la lista -->
                                        <form id="addMemberForm" method="POST"
                                            action="{{ route('asignaturas.addMember') }}">
                                            <input type="hidden" name="_token" id="_token"
                                                value="{{ csrf_token() }}">
                                            <input type="hidden" name="idAsignatura" id="idAsignatura"
                                                value="{{ $asignatura->idAsignatura }}">
                                            <div class="form-group row">
                                                <div class="col-sm-12 d-flex align-items-center">
                                                    <select id="select2">
                                                        <option value="0" readonly selected>SELECCIONAR UN
                                                            ESTUDIANTE</option>
                                                        @foreach ($Estudiantes as $rowEstudiantes)
                                                            <option value="{{ $rowEstudiantes->idEstudiante }}">
                                                                {{ trim('(' . $rowEstudiantes->nombreCurso . ') ' . $rowEstudiantes->apellidoPaterno . ' ' . $rowEstudiantes->apellidoMaterno . ' ' . $rowEstudiantes->nombres) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <p>⠀</p>
                                                    <button type="submit" class="btn btn-success"
                                                        id="btnAnhadirEstudiante">{!! helper_FormatoBotonCRUD(9, 'texto') !!}</button>
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
                                        </form>
                                    @endif

                                    @if ($asignatura->tipoBloque == '1')
                                        <div class="form-group row">
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select class="form-control" id="idCurso" name="idCurso">
                                                    @foreach ($Cursos as $rowCursos)
                                                        <option value="{{ $rowCursos->idCurso }}">
                                                            {{ $rowCursos->nombreCurso }}</option>
                                                    @endforeach
                                                </select>
                                                <p>⠀</p>
                                                <a id="btnRefresh" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#modalRefreshMembers">
                                                    {!! helper_FormatoBotonCRUD(10, 'texto') !!}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Tabla de integrantes -->
                                    <table class="table table-bordered table-striped" id="integrantesTable">
                                        <thead>
                                            <tr>
                                                <th>CURSO</th>
                                                <th>NOMBRE</th>
                                                @if ($asignatura->tipoBloque == '2')
                                                    <th>Acciones</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Integrantes as $rowIntegrante)
                                                <tr>
                                                    <td>{{ $rowIntegrante->nombreCurso }}</td>
                                                    <td>{{ trim($rowIntegrante->apellidoPaterno . ' ' . $rowIntegrante->apellidoMaterno . ' ' . $rowIntegrante->nombres) }}
                                                    </td>
                                                    @if ($asignatura->tipoBloque == '2')
                                                        <td>
                                                            <div class="btn-group">
                                                                <a class="btn btn-danger eliminar-integrante"
                                                                    data-toggle="modal"
                                                                    data-target="#modalDeleteMember" data-iterador="0"
                                                                    data-idestudiante="{{ $rowIntegrante->idEstudiante }}"
                                                                    data-estudiante="{{ trim($rowIntegrante->apellidoPaterno . ' ' . $rowIntegrante->apellidoMaterno . ' ' . $rowIntegrante->nombres) }}">
                                                                    {!! helper_FormatoBotonCRUD(4, 'icono') !!}
                                                                </a>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <p class="font font-weight-bold" id="totalRegistros">Número de Integrantes:
                                        {{ count($Integrantes) }}.</p>
                                    <!-- / Tabla de integrantes -->
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-2" role="tabpanel"
                                    aria-labelledby="custom-tabs-2-tab">
                                    <h3 class="font-weight-bold text-info">LISTA DE MATERIALES</h3>
                                    <!-- Formulario de creación con 2 valores -->
                                    <form action="{{route('listasmateriales.create')}}" method="GET" target="_blank" rel="noopener noreferrer">
                                        <div class="form-group row">
                                            <input type="hidden" name="idAsignatura" value="{{ $asignatura->idAsignatura }}"/>
                                            <div class="col-sm-1 align-content-center">
                                                <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</button>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>MATERIAL</th>
                                                <th>CANTIDAD</th>
                                                <th>UNIDAD DE MEDIDA</th>
                                                <th>OBSERVACION</th>
                                                <th>F. REGISTRO</th>
                                                <th>F. ACTUALIZACION</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Materiales as $rowMateriales)
                                                <tr>
                                                    <td>{{ $rowMateriales->nombreMaterial }}</td>
                                                    <td>{{ $rowMateriales->cantidad }}</td>
                                                    <td>{{ $rowMateriales->unidadMedida }}</td>
                                                    <td>{{ $rowMateriales->observacion }}</td>
                                                    <td>{{ helper_formatoVistaFechayHora($rowMateriales->fechaRegistro) }}</td>
                                                    <td>{{ helper_formatoVistaFechayHora($rowMateriales->fechaActualizacion) }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <form action="{{route('listasmateriales.edit')}}" method="GET" target="_blank" rel="noopener noreferrer">
                                                                <input type="hidden" name="idAsignatura" value="{{$rowMateriales->idAsignatura}}">
                                                                <input type="hidden" name="idMaterial" value="{{$rowMateriales->idMaterial}}">
                                                                <button type="submit" class="btn btn-warning">{!! helper_FormatoBotonCRUD(3, 'icono') !!}</button>
                                                            </form>
                                                            <form action="{{route('listasmateriales.delete')}}" method="POST">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="idAsignatura" value="{{$rowMateriales->idAsignatura}}">
                                                                <input type="hidden" name="idMaterial" value="{{$rowMateriales->idMaterial}}">
                                                                <button type="submit" class="{{ $rowMateriales->estado ? 'btn btn-danger' : 'btn btn-success'}}">{!! $rowMateriales->estado ? helper_FormatoBotonCRUD(4, 'icono') : helper_FormatoBotonCRUD(10, 'icono') !!}</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-3" role="tabpanel"
                                    aria-labelledby="custom-tabs-3-tab">
                                    <h3 class="font-weight-bold text-info">HORARIOS</h3>
                                    <a href="{{ route('horarios.create', $asignatura->idAsignatura) }}" target="_blank" rel="noopener noreferrer"
                                        class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
                                    <br><br>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>DIA</th>
                                                <th>INICIO</th>
                                                <th>FIN</th>
                                                <th>CARGA HORARIA</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalHoras = 0;
                                            @endphp
                                            @foreach ($Horarios as $rowHorario)
                                                <tr>
                                                    <td>{{ helper_FormatoAtributoValorATexto($rowHorario->dia, 'horarioDia') }}</td>
                                                    <td>{{ $rowHorario->horaInicio}}</td>
                                                    <td>{{ $rowHorario->horaFin}}</td>
                                                    <td>{{ helper_calcularMinutos($rowHorario->horaInicio, $rowHorario->horaFin) . ' mins.'}}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info"
                                                                href="{{ route('horarios.details', $rowHorario->idHorario) }}" target="_blank" rel="noopener noreferrer">
                                                                {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                                                            </a>
                                                            <a class="btn btn-warning"
                                                                href="{{ route('horarios.edit', $rowHorario->idHorario) }}" target="_blank" rel="noopener noreferrer">
                                                                {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $totalHoras += helper_calcularMinutos($rowHorario->horaInicio, $rowHorario->horaFin);
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <p class="font font-weight-bold">Tiempo total de carga horaria: {{ $totalHoras }} mins. / {{ intval($totalHoras/60) }} Hrs. y {{ $totalHoras % 60 }} mins.</p>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-4" role="tabpanel"
                                    aria-labelledby="custom-tabs-4-tab">
                                    <h3 class="font-weight-bold text-info">UNIDADES Y SÍLABOS</h3>
                                    <a href="{{ route('unidades.create', $asignatura->idAsignatura) }}" target="_blank" rel="noopener noreferrer"
                                        class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</a>
                                    <br><br>
                                    <!-- Tabla de unidades -->
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>PERIODO</th>
                                                <th>POSICION ORDINAL</th>
                                                <th>UNIDAD</th>
                                                <th>AVANCE</th>
                                                <th>SILABOS</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Unidades as $rowUnidad)
                                                <tr>
                                                    <td>{{ $rowUnidad->nombrePeriodo }}</td>
                                                    <td>{{ $rowUnidad->posicionOrdinal }}</td>
                                                    <td>{{ $rowUnidad->nombreUnidad }}</td>
                                                    <td>{{ round($rowUnidad->porcentajeAvance) . '%' }}
                                                        <div class="progress mb-3">
                                                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{ round($rowUnidad->porcentajeAvance) }}" aria-valuemin="0"
                                                                 aria-valuemax="100" style="width: {{ round($rowUnidad->porcentajeAvance) . '%' }}">
                                                              <span class="sr-only">{{ round($rowUnidad->porcentajeAvance) . '%' }} Completado</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{!! helper_formatoNullorEmpty($rowUnidad->groupConcatSilabos) !!}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info"
                                                                href="{{ route('unidades.details', $rowUnidad->idUnidad) }}" target="_blank" rel="noopener noreferrer">
                                                                {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                                                            </a>
                                                            <a class="btn btn-warning"
                                                                href="{{ route('unidades.edit', $rowUnidad->idUnidad) }}" target="_blank" rel="noopener noreferrer">
                                                                {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                                                            </a>
                                                            <a class="btn btn-success"
                                                                href="{{ route('silabos.create', $rowUnidad->idUnidad) }}" target="_blank" rel="noopener noreferrer">
                                                                {!! helper_FormatoBotonCRUD(1, 'icono') !!}
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- / Tabla de unidades -->
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
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
                    <p>¿Está seguro/a de eliminar el registro seleccionado?</p>
                    <p class="font-weight-bold">{{ $asignatura->nombreAsignatura }}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                    <form action="{{ route('asignaturas.delete') }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="hidden" name="idAsignatura" value="{{ $asignatura->idAsignatura }}">
                        <button type="submit" class="btn btn-danger">{!! helper_FormatoBotonCRUD(4, 'texto') !!}</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modalDeleteMember">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold text-danger">ELIMINAR INTEGRANTE</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro/a de eliminar el estudiante seleccionado de la lista?</p>
                    <p class="font-weight-bold" id="nombreEstudiante">NOMBRE</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                    <form id="deleteMemberForm" method="POST" action="{{ route('asignaturas.deleteMember') }}">
                        <!-- No se asigna csrf porque ya está definido. -->
                        <input type="hidden" name="idAsignatura" value="{{ $asignatura->idAsignatura }}">
                        <input type="hidden" id="deleteIdEstudiante" name="idEstudiante" value="0">
                        <input type="hidden" id="iterador" name="iterador" value="0">
                        <button type="submit" class="btn btn-danger">{!! helper_FormatoBotonCRUD(4, 'texto') !!}</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modalRefreshMembers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold text-warning">REFRESCAR LISTA DE ESTUDIANTES</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Esta acción eliminará todos los registros actuales y las reemplazará por todos los estudiantes
                        del curso seleccionado, ¿Desea continuar?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                    <form method="POST" action="{{ route('asignaturas.refreshMembers') }}">
                        @csrf
                        <input type="hidden" name="idAsignatura" value="{{ $asignatura->idAsignatura }}">
                        <input type="hidden" id="refreshIdCurso" name="idCurso" value="0">
                        <button type="submit" class="btn btn-warning">{!! helper_FormatoBotonCRUD(10, 'texto') !!}</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@include('Layouts.footerStart')
@include('Asignatura.detalleScripts')
@include('Layouts.footerEnd')
