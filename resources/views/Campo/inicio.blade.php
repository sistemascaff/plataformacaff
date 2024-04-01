@include('header')
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
            <li class="breadcrumb-item"><a href="{{route('campos.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">CAMPOS</li>
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
        <h3 class="card-title font-weight-bold">CAMPOS</h3>
      </div>
      <div class="card-body">
        <a href="{{route('campos.create')}}" class="btn btn-success">NUEVO REGISTRO</a>
        <br><br>
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>CAMPO</th>
                  <th>F. REGISTRO</th>
                  <th>F. ACTUALIZACION</th>
                  <th>MODIFICADO POR</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableCampo as $rowCampo)
                  <tr>
                    <td>{{$rowCampo->nombreCampo}}</td>
                    <td>{{formatoVistaFechayHora($rowCampo->fechaRegistro)}}</td>
                    <td>{{formatoVistaFechayHora($rowCampo->fechaActualizacion)}}</td>
                    <td>{{formatoNullorEmpty($rowCampo->correo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('campos.details', $rowCampo->idCampo)}}">
                          <i class="fa fa-eye"></i>
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
  @include('footer')