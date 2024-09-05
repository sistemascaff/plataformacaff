@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">REGISTRAR {{$Titulos}}</h1>
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
        <h3 class="card-title font-weight-bold">{{$Titulos}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <form class="form-horizontal" action="{{route('libros.store')}}" method="POST">

              @csrf

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TÍTULO (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombreLibro') is-invalid @enderror"
                      name="nombreLibro" value="{{old('nombreLibro')}}" placeholder="TÍTULO" minlength="1" maxlength="200" required autofocus>
                  </div>
                  @error('nombreLibro')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CÓDIGO LIBRO (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('codigoLibro') is-invalid @enderror"
                      name="codigoLibro" value="{{old('codigoLibro',$formatoCodigo->codigo)}}" placeholder="CÓDIGO" minlength="1" maxlength="5" required>
                  </div>
                  @error('codigoLibro')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">COSTO (*)</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control @error('costo') is-invalid @enderror"
                      name="costo" value="{{old('costo')}}" placeholder="1,00" step="0.50" min="0" required>
                  </div>
                  @error('costo')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">OBSERVACIÓN/ES (*)</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="observacion" required>{{old('observacion','-')}}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">DESCRIPCIÓN (*)</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="descripcion" required>{{old('descripcion','-')}}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ADQUISICIÓN (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('adquisicion') is-invalid @enderror" name="adquisicion" required>
                      <option value="1" {{old('adquisicion') == '1' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(1, 'libroAdquisicion')}}</option>
                      <option value="2" {{old('adquisicion') == '2' ? 'selected' : ''}}>{{helper_FormatoAtributoValorATexto(2, 'libroAdquisicion')}}</option>
                    </select>
                  </div>
                  @error('adquisicion')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CATEGORIA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idCategoria" required>
                      @foreach ($Categorias as $rowCategorias)
                      @if ($rowCategorias->idCategoria == $idSelect)
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
                    <select class="form-control" name="idAutor" id="select2"required>
                      @foreach ($Autores as $rowAutores)
                      @if ($rowAutores->idAutor == $idSelect)
                      <option value="{{$rowAutores->idAutor}}" selected>{{$rowAutores->nombreAutor}}</option>
                      @else
                      <option value="{{$rowAutores->idAutor}}">{{$rowAutores->nombreAutor}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">EDITORIAL (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idEditorial" id="selectTwo" required>
                      @foreach ($Editoriales as $rowEditoriales)
                      @if ($rowEditoriales->idEditorial == $idSelect)
                      <option value="{{$rowEditoriales->idEditorial}}" selected>{{$rowEditoriales->nombreEditorial}}</option>
                      @else
                      <option value="{{$rowEditoriales->idEditorial}}">{{$rowEditoriales->nombreEditorial}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">PRESENTACIÓN (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idPresentacion" required>
                      @foreach ($Presentaciones as $rowPresentaciones)
                      @if ($rowPresentaciones->idPresentacion == $idSelect)
                      <option value="{{$rowPresentaciones->idPresentacion}}" selected>{{$rowPresentaciones->nombrePresentacion}}</option>
                      @else
                      <option value="{{$rowPresentaciones->idPresentacion}}">{{$rowPresentaciones->nombrePresentacion}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('libros.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
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