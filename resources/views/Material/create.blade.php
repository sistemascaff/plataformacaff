@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">REGISTRAR NUEVO MATERIAL</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('materiales.index')}}">MATERIALES</a></li>
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
            <form class="form-horizontal" action="{{route('materiales.store')}}" method="POST">

              @csrf

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRE MATERIAL (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('nombreMaterial') is-invalid @enderror"
                    name="nombreMaterial" value="{{old('nombreMaterial')}}" placeholder="MATERIAL" minlength="1" maxlength="100" required autofocus>
                  </div>
                  @error('nombreMaterial')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
              </div>
              <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('materiales.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
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