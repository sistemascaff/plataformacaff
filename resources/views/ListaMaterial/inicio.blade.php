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
            <li class="breadcrumb-item"><a href="{{route('listasmateriales.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">LISTAS DE MATERIALES</li>
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
        <h3 class="card-title font-weight-bold">LISTAS DE MATERIALES</h3>
      </div>
      <div class="card-body">
        <!-- Formulario de creación con 2 valores -->
        <form action="{{route('listasmateriales.create')}}" method="GET">
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">ASIGNATURA (*)</label>
            <div class="col-sm-4 align-content-center">
              <select class="form-control" name="idAsignatura" id="select2" required>
                @foreach ($Asignaturas as $rowAsignaturas)
                <option value="{{$rowAsignaturas->idAsignatura}}">{{$rowAsignaturas->nombreAsignatura}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-1 align-content-center">
              <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</button>
            </div>
          </div>
        </form>
        <br>
        <!-- Formulario de búsqueda -->
        <form action="{{route('listasmateriales.index')}}" method="GET">
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
            <a href="{{route('listasmateriales.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ASIGNATURA</th>
                  <th>DOCENTE</th>
                  <th>MATERIAL</th>
                  <th>CANTIDAD</th>
                  <th>UNIDAD DE MEDIDA</th>
                  <th>OBSERVACIONES</th>
                  <th>F. REGISTRO</th>
                  <th>F. ACTUALIZACION</th>
                  <th>MODIFICADO POR</th>
                  <th>ACCIONES</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableListaMaterial as $rowListaMaterial)
                  <tr>
                    <td>{{$rowListaMaterial->nombreAsignatura}}</td>
                    <td>{{trim($rowListaMaterial->apellidoPaterno . ' ' . $rowListaMaterial->apellidoMaterno . ' ' . $rowListaMaterial->nombres)}}</td>
                    <td>{{$rowListaMaterial->nombreMaterial}}</td>
                    <td>{{$rowListaMaterial->cantidad}}</td>
                    <td>{{$rowListaMaterial->unidadMedida}}</td>
                    <td>{{$rowListaMaterial->observacion}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowListaMaterial->fechaRegistro)}}</td>
                    <td>{{helper_formatoVistaFechayHora($rowListaMaterial->fechaActualizacion)}}</td>
                    <td>{{helper_formatoNullorEmpty($rowListaMaterial->correo)}}</td>
                    <td>
                      <div class="btn-group">
                        <form action="{{route('listasmateriales.details')}}" method="GET">
                          <input type="hidden" name="idAsignatura" value="{{$rowListaMaterial->idAsignatura}}">
                          <input type="hidden" name="idMaterial" value="{{$rowListaMaterial->idMaterial}}">
                          <button type="submit" class="btn btn-info">{!! helper_FormatoBotonCRUD(2, 'icono') !!}</button>
                        </form>
                        <form action="{{route('listasmateriales.edit')}}" method="GET">
                            <input type="hidden" name="idAsignatura" value="{{$rowListaMaterial->idAsignatura}}">
                            <input type="hidden" name="idMaterial" value="{{$rowListaMaterial->idMaterial}}">
                            <button type="submit" class="btn btn-warning">{!! helper_FormatoBotonCRUD(3, 'icono') !!}</button>
                        </form>
                        <form action="{{route('listasmateriales.delete')}}" method="POST">
                          @csrf
                          @method('put')
                          <input type="hidden" name="idAsignatura" value="{{$rowListaMaterial->idAsignatura}}">
                          <input type="hidden" name="idMaterial" value="{{$rowListaMaterial->idMaterial}}">
                          <button type="submit" class="{{ $rowListaMaterial->estado ? 'btn btn-danger' : 'btn btn-success'}}">{!! $rowListaMaterial->estado ? helper_FormatoBotonCRUD(4, 'icono') : helper_FormatoBotonCRUD(13, 'icono') !!}</button>
                        </form>
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