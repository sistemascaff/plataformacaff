@include('Usuario.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Blank Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
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
        <h3 class="card-title">Título</h3>
      </div>
      <div class="card-body">
        Start creating your amazing application!
        
        <table id="dataTable-advanced" table table-bordered table-striped">
          <thead>
            <tr>
              <th>CABEZA</th>
              <th>CABEZA 2</th>
              <th>CABEZA 3</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tableUsuario as $rowUsuario)
              <tr>
                <td>{{$rowUsuario->correo}}</td>
                <td>{{$rowUsuario->correo}}</td>
                <td>{{$rowUsuario->correo}}</td>
              </tr>
            @endforeach
          </tbody>        
        </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        Footer
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
  @include('Usuario.footer')