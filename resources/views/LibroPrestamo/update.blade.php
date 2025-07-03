@include('Layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">PRÉSTAMO DE LIBROS N° {{$libroprestamo->idLibrosPrestamo}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('libros.index')}}">PRÉSTAMOS DE LIBROS</a></li>
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
        <h3 class="card-title font-weight-bold">{{$Titulos.' N° '.$libroprestamo->idLibrosPrestamo}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <form class="form-horizontal" action="{{route('librosprestamos.update',$libroprestamo)}}" method="POST">

              @csrf
              @method('put')

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">LECTOR (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idPersona" id="select2" required>
                      @foreach ($Personas as $rowPersonas)
                      @if ($rowPersonas->idPersona == $libroprestamo->idPersona)
                      <option value="{{$rowPersonas->idPersona}}" selected>{{trim('(' . $rowPersonas->tipoPerfil . ') ' . $rowPersonas->apellidoPaterno . ' ' . $rowPersonas->apellidoMaterno . ' ' . $rowPersonas->nombres)}}</option>
                      @else
                      <option value="{{$rowPersonas->idPersona}}">{{trim('(' . $rowPersonas->tipoPerfil . ') ' . $rowPersonas->apellidoPaterno . ' ' . $rowPersonas->apellidoMaterno . ' ' . $rowPersonas->nombres)}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CELULAR (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('celular') is-invalid @enderror"
                    name="celular" value="{{old('celular', $libroprestamo->celular)}}" placeholder="72345678" maxlength="20" required>
                  </div>
                  @error('celular')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">FECHA DE DEVOLUCIÓN (*)</label>
                  <div class="col-sm-10">
                  <input type="date" class="form-control @error('fechaDevolucion') is-invalid @enderror"
                    name="fechaDevolucion" value="{{old('fechaDevolucion',  date("Y-m-d", strtotime($libroprestamo->fechaDevolucion)))}}" required>
                  </div>
                  @error('fechaDevolucion')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label bg-success rounded">AÑADIR UN NUEVO LIBRO:</label>
                  <div class="col-sm-10 align-self-center">
                    <select class="form-control" name="idLibro" id="selectTwo" required>
                      <option value="0" selected>-- NO AGREGAR NINGÚN LIBRO --</option>
                      @foreach ($Libros as $rowLibros)
                        <option value="{{$rowLibros->idLibro}}" {{ ($rowLibros->estado != '1') ? 'disabled' : '' }}>{{helper_FormatoAtributoValorATexto($rowLibros->estado, 'libroEstado') . ' - ' . $rowLibros->codigoLibro . ' - ' . $rowLibros->nombreLibro}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @if (session('mensaje'))
                <br>
                <div class="alert alert-warning">
                  <h5 class="font font-weight-bold"><i class="icon fa fa-warning"></i> ¡ATENCIÓN!</h5>
                  <a>{{session('mensaje')}}</a>
                </div>
                @endif
              </div>
              
              <a class="btn btn-warning" data-toggle="modal" data-target="#modalUpdate">
                {!! helper_FormatoBotonCRUD(3, 'texto') !!}
              </a>
              <a href="{{route('librosprestamos.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>

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
  @include('Layouts.footerStart')
@include('Layouts.footerEnd')