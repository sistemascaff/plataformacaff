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
            <li class="breadcrumb-item"><a href="{{route('areas.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">AREAS</li>
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
        <h3 class="card-title font-weight-bold">AREAS</h3>
      </div>
      <div class="card-body">
        <a href="{{route('areas.create')}}" class="btn btn-success">NUEVO REGISTRO</a>
        <br><br>
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>AREA</th>
                  <th>CAMPO</th>
                  <th>F. REGISTRO</th>
                  <th>F. ACTUALIZACION</th>
                  <th>MODIFICADO POR</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tableArea as $rowArea)
                  <tr>
                    <td>{{$rowArea->nombreArea}}</td>
                    <td>{{$rowArea->nombreCampo}}</td>
                    <td>{{formatoVistaFechayHora($rowArea->fechaRegistro)}}</td>
                    <td>{{formatoVistaFechayHora($rowArea->fechaActualizacion)}}</td>
                    <td>{{formatoNullorEmpty($rowArea->correo)}}</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-info" href="{{route('areas.details', $rowArea->idArea)}}">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-warning" href="{{route('areas.edit',$rowArea->idArea)}}">
                          <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-danger eliminar-registro" data-toggle="modal" data-target="#modalDelete" data-id="{{$rowArea->idArea}}" data-nombre="{{$rowArea->nombreArea}}">
                          <i class="fa fa-trash"></i>
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
          <p>¿Está segur@ de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold" id="nombre">NOMBRE</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('areas.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="idArea" value="0">
            <button type="submit" class="btn btn-danger">ELIMINAR</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- /.content -->
  @include('footer')