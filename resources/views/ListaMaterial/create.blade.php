@include('Layouts.header')
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
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('listasmateriales.index')}}">HORARIOS</a></li>
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
            <form class="form-horizontal" action="{{route('listasmateriales.store')}}" method="POST" id="createForm">

              @csrf

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ASIGNATURA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idAsignatura" id="select2" required>
                      @foreach ($Asignaturas as $rowAsignaturas)
                      @if ($rowAsignaturas->idAsignatura == $idSelect)
                      <option value="{{$rowAsignaturas->idAsignatura}}" selected>{{$rowAsignaturas->nombreAsignatura}}</option>
                      @else
                      <option value="{{$rowAsignaturas->idAsignatura}}">{{$rowAsignaturas->nombreAsignatura}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">MATERIAL (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idMaterial" id="selectTwo" required>
                      @foreach ($Materiales as $rowMateriales)
                      <option value="{{$rowMateriales->idMaterial}}">{{'(' . $rowMateriales->unidadMedida . ') ' . $rowMateriales->nombreMaterial}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CANTIDAD (*)</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control @error('cantidad') is-invalid @enderror"
                      name="cantidad" value="{{old('cantidad', '1')}}" placeholder="1" step="1" min="1" required>
                  </div>
                  @error('cantidad')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">OBSERVACION (*)</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="observacion" required>{{old('observacion','-')}}</textarea>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('listasmateriales.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
              </form>

              @if (session('mensaje'))
                <br>
                <div class="alert alert-warning">
                  <h5 class="font font-weight-bold"><i class="icon fa fa-ban"></i> ¡ATENCIÓN!</h5>
                  <a>{{session('mensaje')}}</a>
                  <br><br>
                  <form action="{{route('listasmateriales.edit')}}" method="GET">
                    <input type="hidden" name="idAsignatura" value="{{ session('existenciaIdAsignatura') }}">
                    <input type="hidden" name="idMaterial" value="{{ session('existenciaIdMaterial') }}">
                    <button type="submit" class="btn btn-light border-dark font-weight-bold" id="createSubmitButton">{!! helper_FormatoBotonCRUD(3, 'texto') !!}</button>
                  </form>
                </div>
              @endif
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