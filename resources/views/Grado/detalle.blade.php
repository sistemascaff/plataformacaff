@include('header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$grado->nombreGrado}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('grados.index')}}">AREAS</a></li>
            <li class="breadcrumb-item active">{{$grado->nombreGrado}}</li>
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
          <a class="btn btn-info" href="{{route('grados.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
          <a class="btn btn-warning" href="{{route('grados.edit',$grado->idGrado)}}">
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
              <label for="inputEmail3" class="col-md-2 col-form-label">Grado</label>
              <div class="col-md-10">
                <p class="form form-control">{{$grado->nombreGrado}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Posición Ordinal</label>
              <div class="col-md-10">
                <p class="form form-control">{{$grado->posicionOrdinal}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Nivel</label>
              <div class="col-md-10">
                <a href="{{route('niveles.details', $nivel->idNivel)}}" class="form form-control font-weight-bold">{{$nivel->nombreNivel}}</a>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-10">
                <p class="form form-control">{{$grado->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($grado->fechaActualizacion)}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Actualizado por</label>
              <div class="col-md-10">
                <p class="form form-control">{{helper_formatoNullorEmpty($usuario->correo)}}</p>
              </div>
            </div>
          </div>
        </div>
        
        <h3 class="card-title font-weight-bold">CURSOS DEPENDIENTES DE {{$nivel->nombreNivel}}:</h3>
        <br><br>
        <!-- Formulario de creación con 2 valores -->
        <form action="{{route('cursos.create')}}" method="GET">
          <div class="form-group row">
            <label class="col-sm-1 col-form-label">PARALELO (*)</label>
            <div class="col-sm-4 align-content-center">
              <select class="form-control" name="idParalelo" required>
                @foreach ($Paralelos as $rowParalelos)
                <option value="{{$rowParalelos->idParalelo}}">{{$rowParalelos->nombreParalelo}}</option>
                @endforeach
              </select>
            </div>
            <input type="hidden" name="idGrado" value="{{$grado->idGrado}}">
            <div class="col-sm-1 align-content-center">
              <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(1, 'texto') !!}</button>
            </div>
          </div>
      </form>
      <br>
      <!-- /Formulario de creación con 2 valores -->

        <div class="col-md-12">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>CURSO</th>
                <th>F. REGISTRO</th>
                <th>F. ACTUALIZACION</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
          @foreach ($Cursos as $rowCursos)
          <tr>
            <td>{{$rowCursos->nombreCurso}}</td>
            <td>{{helper_formatoVistaFechayHora($rowCursos->fechaRegistro)}}</td>
            <td>{{helper_formatoVistaFechayHora($rowCursos->fechaActualizacion)}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-info" href="{{route('cursos.details', $rowCursos->idCurso)}}">
                  {!! helper_FormatoBotonCRUD(2, 'icono') !!}
                </a>
                <a class="btn btn-warning" href="{{route('cursos.edit', $rowCursos->idCurso)}}">
                  {!! helper_FormatoBotonCRUD(3, 'icono') !!}
                </a>
              </div>
            </td>
          </tr>
          @endforeach
            </tbody>
          </table>
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
          <p>¿Está segur@ de eliminar el registro seleccionado?</p>
          <p class="font-weight-bold">{{$grado->nombreGrado}}</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
          <form action="{{route('grados.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="idGrado" value="{{$grado->idGrado}}">
            <button type="submit" class="btn btn-danger">{!! helper_FormatoBotonCRUD(4, 'texto') !!}</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  @include('footer')