@include('layouts.header')
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
            <li class="breadcrumb-item"><a href="{{route('editoriales.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">EDITORIALES</li>
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
        <h3 class="card-title font-weight-bold">EDITORIALES: <span class="text-info">{{ count($tableEditorial) }}</span> REGISTROS.</h3>
      </div>
      <div class="card-body">
        <!-- Formulario de búsqueda -->
        <form action="{{route('editoriales.index')}}" method="GET">
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
            <a href="{{route('editoriales.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'icono') !!}</a>
          </h3>
          <br>
        @endif
        <!-- / Formulario de búsqueda -->
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>EDITORIAL</th>
                  <th>LIBROS</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableEditorial as $rowEditorial)
                  <tr>
                    <td>{{$rowEditorial->nombreEditorial}}</td>
                    <td>{{$rowEditorial->countLibros}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('editoriales.details', $rowEditorial->nombreEditorial)}}">
                          {!! helper_FormatoBotonCRUD(2, 'icono') !!}
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
  @include('layouts.footerStart')
@include('layouts.footerEnd')