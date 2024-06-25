@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item active">{{$persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres}}</li>
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
        <div class="btn-group">
          <a class="btn btn-info" href="{{route('usuarios.index')}}">
            {!! helper_FormatoBotonCRUD(7, 'texto') !!}
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 p-2">
            <h3 class="font-weight-bold text-info text-center">{{$persona->tipoPerfil}}</h3>
            <img src="{{$persona_usuario->fotoPerfilURL}}" class="profile-user-img img-square rounded mx-auto d-block" style="width:350px;height:350px;" alt="{{$persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres}}">
          </div>
        </div>
        <div class="row">
          <!-- Columna 1 -->
          <div class="col-md-6">
            <h3 class="font-weight-bold text-info">DATOS PERSONALES</h3>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Apellido Paterno</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->apellidoPaterno}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Apellido Materno</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->apellidoMaterno}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Nombre/s</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->nombres}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Cédula de Identidad/s</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->documentoIdentificacion}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">C.I. Complemento</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->documentoComplemento}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">C.I. Expedido en</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->documentoExpedido}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Nacimiento</label>
              <div class="col-md-8">
                <p class="form form-control">{{helper_formatoVistaFecha($persona->fechaNacimiento)}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Sexo</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->sexo}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Idioma/s</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->idioma}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Nivel I.E.</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->nivelIE}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Registro</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona->fechaRegistro}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Fecha de Actualizacion</label>
              <div class="col-md-8">
                <p class="form form-control">{{helper_formatoNullorEmpty($persona->fechaActualizacion)}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Actualizado por</label>
              <div class="col-md-8">
                <p class="form form-control">{{helper_formatoNullorEmpty($usuario->correo)}}</p>
              </div>
            </div>
          </div><!-- Columna 1 -->
          <!-- Columna 2 -->
          <div class="col-md-6">
            <h3 class="font-weight-bold text-info">DATOS DE USUARIO</h3>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">Correo</label>
              <div class="col-md-8">
                <p class="form form-control">{{$persona_usuario->correo}}</p>
              </div>
            </div>

            @if ($estudiante)
            <h3 class="font-weight-bold text-info rounded">DATOS DE SALUD</h3>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">TIPO DE SANGRE</label>
              <div class="col-md-8">
                <p class="form form-control">{{$estudiante->saludTipoSangre}}</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">ALERGIAS</label>
              <div class="col-md-8">
                <textarea class="form-control" readonly>{{$estudiante->saludAlergias}}</textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-md-2 col-form-label">DATOS MÉDICOS IMPORTANTES</label>
              <div class="col-md-8">
                <textarea class="form-control" readonly>{{$estudiante->saludDatos}}</textarea>
              </div>
            </div>
            @endif

          </div><!-- / Columna 2 -->
        </div>
        
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->

  @include('layouts.footer')