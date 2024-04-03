@include('header')
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
            <li class="breadcrumb-item"><a href="{{route('areas.index')}}">AREA</a></li>
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
            <form class="form-horizontal" action="{{route('areas.store')}}" method="POST">

              @csrf

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRE AREA</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombreArea" placeholder="AREA" minlength="5" maxlength="45" required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CAMPO</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idCampo" required>
                      @foreach ($Campos as $rowCampos)
                      <option value="{{$rowCampos->idCampo}}">{{$rowCampos->nombreCampo}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success">REGISTRAR</button>
              <a href="{{route('areas.index')}}" class="btn btn-secondary">CANCELAR</a>
              </form>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
  @include('footer')