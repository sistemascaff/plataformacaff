@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$libro->nombreLibro}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('libros.index')}}">LIBROS</a></li>
            <li class="breadcrumb-item active">{{$Titulos}}</li>
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
        <h3 class="card-title font-weight-bold">{{$Titulos.': '.$libro->nombreLibro}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <form class="form-horizontal" action="{{route('libros.update',$libro)}}" method="POST">

              @csrf
              @method('put')

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TÍTULO (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('nombreLibro') is-invalid @enderror"
                    name="nombreLibro" value="{{old('nombreLibro', $libro->nombreLibro)}}" placeholder="LIBRO" minlength="1" maxlength="200" required autofocus>
                  </div>
                  @error('nombreLibro')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CÓDIGO LIBRO (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('codigoLibro') is-invalid @enderror"
                    name="codigoLibro" value="{{old('codigoLibro', $libro->codigoLibro)}}" placeholder="CÓDIGO" minlength="1" maxlength="5" required>
                  </div>
                  @error('codigoLibro')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">COSTO (*)</label>
                  <div class="col-sm-10">
                  <input type="number" class="form-control @error('costo') is-invalid @enderror"
                    name="costo" value="{{old('costo', $libro->costo)}}" placeholder="1.00" step="0.01" min="0" required>
                  </div>
                  @error('costo')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">COSTO (*)</label>
                  <div class="col-sm-10">
                  <input type="number" class="form-control @error('anhoLibro') is-invalid @enderror"
                    name="anhoLibro" value="{{old('anhoLibro', $libro->anhoLibro)}}" placeholder="1.00" step="1" min="0" required>
                  </div>
                  @error('anhoLibro')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">OBSERVACIÓN/ES (*)</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="observacion" required>{{old('observacion', $libro->observacion)}}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">DESCRIPCIÓN (*)</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="descripcion" required>{{old('descripcion', $libro->descripcion)}}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ADQUISICIÓN (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('adquisicion') is-invalid @enderror" name="adquisicion" required>
                      <option value="1" {{$libro->adquisicion == '1' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(1, 'libroAdquisicion')}}</option>
                      <option value="2" {{$libro->adquisicion == '2' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(2, 'libroAdquisicion')}}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CATEGORIA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idCategoria" id="select2" required>
                      @foreach ($Categorias as $rowCategorias)
                      @if ($rowCategorias->idCategoria == $libro->idCategoria)
                      <option value="{{$rowCategorias->idCategoria}}" selected>{{$rowCategorias->nombreCategoria}}</option>
                      @else
                      <option value="{{$rowCategorias->idCategoria}}">{{$rowCategorias->nombreCategoria}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">AUTOR (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('nombreAutor') is-invalid @enderror"
                    name="nombreAutor" value="{{old('nombreAutor', $libro->nombreAutor)}}" placeholder="AUTOR" minlength="1" maxlength="100" list="autores" required>
                  </div>
                  <datalist id="autores">
                    @foreach ($Autores as $rowAutores)
                    <option value="{{$rowAutores->nombreAutor}}">{{$rowAutores->nombreAutor}}</option>
                    @endforeach
                  </datalist>
                  @error('nombreAutor')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">EDITORIAL (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('nombreEditorial') is-invalid @enderror"
                    name="nombreEditorial" value="{{old('nombreEditorial', $libro->nombreEditorial)}}" placeholder="AUTOR" minlength="1" maxlength="100" list="editoriales" required>
                  </div>
                  <datalist id="editoriales">
                    @foreach ($Editoriales as $rowEditoriales)
                    <option value="{{$rowEditoriales->nombreEditorial}}">{{$rowEditoriales->nombreEditorial}}</option>
                    @endforeach
                  </datalist>
                  @error('nombreEditorial')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">PRESENTACION (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idPresentacion" required>
                      @foreach ($Presentaciones as $rowPresentaciones)
                      @if ($rowPresentaciones->idPresentacion == $libro->idPresentacion)
                      <option value="{{$rowPresentaciones->idPresentacion}}" selected>{{$rowPresentaciones->nombrePresentacion}}</option>
                      @else
                      <option value="{{$rowPresentaciones->idPresentacion}}">{{$rowPresentaciones->nombrePresentacion}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">FECHA DE INGRESO COOPERATIVA (*)</label>
                  <div class="col-sm-10">
                  <input type="date" class="form-control @error('fechaIngresoCooperativa') is-invalid @enderror"
                    name="fechaIngresoCooperativa" value="{{old('fechaIngresoCooperativa',  date("Y-m-d", strtotime($libro->fechaIngresoCooperativa)))}}" required>
                  </div>
                  @error('fechaIngresoCooperativa')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
              </div>
              
              <a class="btn btn-warning" data-toggle="modal" data-target="#modalUpdate">
                {!! helper_FormatoBotonCRUD(3, 'texto') !!}
              </a>
              <a href="{{route('libros.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>

              <div class="modal fade" id="modalUpdate">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title font-weight-bold text-warning">EDITAR REGISTRO</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="font-weight-bold">¿Está segur@ de haber ingresado los datos correctamente? Presione EDITAR para confirmar.</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                      <button type="submit" class="btn btn-warning">{!! helper_FormatoBotonCRUD(3, 'texto') !!}</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->

              </form>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
  @include('layouts.footer')