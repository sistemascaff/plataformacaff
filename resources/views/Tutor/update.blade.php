@include('layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold">{{$docente->apellidoPaterno}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('usuarios.index')}}">INICIO</a></li>
            <li class="breadcrumb-item"><a href="{{route('docentes.index')}}">DOCENTES</a></li>
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
            <form class="form-horizontal" action="{{route('docentes.update',$docente)}}" method="POST" enctype="multipart/form-data" id="formularioPerfil">

              @csrf
              @method('put')

              <div class="card-body">

                <h3 class="font-weight-bold text-info rounded">DATOS PERSONALES</h3>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">APELLIDO PATERNO</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('apellidoPaterno') is-invalid @enderror"
                    name="apellidoPaterno" id="apellidoPaterno" value="{{old('apellidoPaterno', $persona->apellidoPaterno)}}" placeholder="AP. PATERNO" minlength="1" maxlength="50" autofocus>
                  </div>
                  @error('apellidoPaterno')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">APELLIDO MATERNO</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('apellidoMaterno') is-invalid @enderror"
                    name="apellidoMaterno" id="apellidoMaterno" value="{{old('apellidoMaterno', $persona->apellidoMaterno)}}" placeholder="AP. MATERNO" minlength="1" maxlength="50">
                  </div>
                  @error('apellidoMaterno')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRES (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                    name="nombres" id="nombres" value="{{old('nombres', $persona->nombres)}}" placeholder="NOMBRES" minlength="1" maxlength="50" required>
                  </div>
                  @error('nombres')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CÉDULA DE IDENTIDAD (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('documentoIdentificacion') is-invalid @enderror"
                    name="documentoIdentificacion" id="documentoIdentificacion" value="{{old('documentoIdentificacion', $persona->documentoIdentificacion)}}" placeholder="C.I." minlength="1" maxlength="15" required>
                  </div>
                  @error('documentoIdentificacion')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">C.I. COMPLEMENTO</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('documentoComplemento') is-invalid @enderror"
                    name="documentoComplemento" value="{{old('documentoComplemento', $persona->documentoComplemento)}}" placeholder="C.I. COMP." minlength="1" maxlength="10">
                  </div>
                  @error('documentoComplemento')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">C.I. EXPEDIDO (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="documentoExpedido" required>
                      <option {{$persona->documentoExpedido == 'COCHABAMBA' ? 'selected' : ''}}>COCHABAMBA</option>
                      <option {{$persona->documentoExpedido == 'BENI' ? 'selected' : ''}}>BENI</option>
                      <option {{$persona->documentoExpedido == 'CHUQUISACA' ? 'selected' : ''}}>CHUQUISACA</option>
                      <option {{$persona->documentoExpedido == 'LA PAZ' ? 'selected' : ''}}>LA PAZ</option>
                      <option {{$persona->documentoExpedido == 'ORURO' ? 'selected' : ''}}>ORURO</option>
                      <option {{$persona->documentoExpedido == 'PANDO' ? 'selected' : ''}}>PANDO</option>
                      <option {{$persona->documentoExpedido == 'POTOSI' ? 'selected' : ''}}>POTOSI</option>
                      <option {{$persona->documentoExpedido == 'SANTA CRUZ' ? 'selected' : ''}}>SANTA CRUZ</option>
                      <option {{$persona->documentoExpedido == 'TARIJA' ? 'selected' : ''}}>TARIJA</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">FECHA DE NACIMIENTO (*)</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control @error('fechaNacimiento') is-invalid @enderror"
                      name="fechaNacimiento" id="fechaNacimiento" value="{{$persona->fechaNacimiento}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">SEXO (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
                      <option {{$persona->sexo == 'MASCULINO' ? 'selected' : ''}}>MASCULINO</option>
                      <option {{$persona->sexo == 'FEMENINO' ? 'selected' : ''}}>FEMENINO</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">IDIOMA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('idioma') is-invalid @enderror" name="idioma" required>
                      <option selected>ESPAÑOL</option>
                      <option {{$persona->idioma == 'ALEMÁN' ? 'selected' : ''}}>ALEMÁN</option>
                      <option {{$persona->idioma == 'ESPAÑOL-ALEMÁN' ? 'selected' : ''}}>ESPAÑOL-ALEMÁN</option>
                      <option {{$persona->idioma == 'ESPAÑOL-INGLÉS' ? 'selected' : ''}}>ESPAÑOL-INGLÉS</option>
                      <option {{$persona->idioma == 'INGLÉS' ? 'selected' : ''}}>INGLÉS</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NIVEL I.E. (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('nivelIE') is-invalid @enderror" name="nivelIE" required>
                      <option selected>NINGUNO</option>
                      <option {{$persona->nivelIE == 'A1' ? 'selected' : ''}}>A1</option>
                      <option {{$persona->nivelIE == 'A2' ? 'selected' : ''}}>A2</option>
                      <option {{$persona->nivelIE == 'B1' ? 'selected' : ''}}>B1</option>
                      <option {{$persona->nivelIE == 'B2' ? 'selected' : ''}}>B2</option>
                      <option {{$persona->nivelIE == 'C1' ? 'selected' : ''}}>C1</option>
                      <option {{$persona->nivelIE == 'C2' ? 'selected' : ''}}>C2</option>
                      <option {{$persona->nivelIE == 'DSD I' ? 'selected' : ''}}>DSD I</option>
                      <option {{$persona->nivelIE == 'DSD II' ? 'selected' : ''}}>DSD II</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CELULAR PERSONAL</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('celularPersonal') is-invalid @enderror"
                    name="celularPersonal" value="{{old('celularPersonal', $persona->celularPersonal)}}" placeholder="EJ. 72345678" minlength="1" maxlength="50" autofocus>
                  </div>
                  @error('celularPersonal')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TELEFONO PERSONAL</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('telefonoPersonal') is-invalid @enderror"
                    name="telefonoPersonal" value="{{old('telefonoPersonal', $persona->telefonoPersonal)}}" placeholder="EJ. 4234567" minlength="1" maxlength="50" autofocus>
                  </div>
                  @error('telefonoPersonal')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <h3 class="font-weight-bold text-info rounded">DATOS DE USUARIO</h3>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CORREO (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('correo') is-invalid @enderror"
                    name="correo" id="correo" value="{{old('correo', $persona_usuario->correo)}}" placeholder="correo@froebel.edu.bo" minlength="8" maxlength="80" required>
                  </div>
                  @error('correo')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CONTRASEÑA (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('contrasenha') is-invalid @enderror"
                    name="contrasenha" id="contrasenha" value="{{old('contrasenha', helper_decrypt($persona_usuario->contrasenha))}}" placeholder="C.I. COMP." minlength="8" maxlength="80" required>
                  </div>
                  @error('contrasenha')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">PIN DE RECUPERACION (*)</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('pinRecuperacion') is-invalid @enderror"
                    name="pinRecuperacion" id="pinRecuperacion" value="{{old('pinRecuperacion', $persona_usuario->pinRecuperacion)}}" placeholder="C.I. COMP." minlength="8" maxlength="8" required>
                  </div>
                  @error('pinRecuperacion')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <div class="col-md-12 p-2">
                    <img src="{{$persona_usuario->fotoPerfilURL}}" class="profile-user-img img-square rounded mx-auto d-block" style="width:350px;height:350px;" alt="{{$persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">FOTO DE PERFIL (OPCIONAL)</label>
                  <div class="col-sm-10">
                    <input type="file" name="fotoPerfilURL" class="form-control @error('fotoPerfilURL') is-invalid @enderror" >
                  </div>
                  @error('fotoPerfilURL')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <h3 class="font-weight-bold text-info rounded">DATOS DE DOCENTE/A</h3>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ESPECIALIDAD (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('especialidad') is-invalid @enderror" name="especialidad" required>
                      <option disabled selected>-SELECCIONAR-</option>
                      <option {{$docente->especialidad == 'INICIAL - UNIDOCENTE' ? 'selected' : ''}}>INICIAL - UNIDOCENTE</option>
                      <option {{$docente->especialidad == 'INICIAL - ALEMÁN' ? 'selected' : ''}}>INICIAL - ALEMÁN</option>
                      <option {{$docente->especialidad == 'INICIAL - ARTÍSTICA' ? 'selected' : ''}}>INICIAL - ARTÍSTICA</option>
                      <option {{$docente->especialidad == 'INICIAL - DEPORTIVA' ? 'selected' : ''}}>INICIAL - DEPORTIVA</option>
                      <option {{$docente->especialidad == 'PRIMARIA - UNIDOCENTE' ? 'selected' : ''}}>PRIMARIA - UNIDOCENTE</option>
                      <option {{$docente->especialidad == 'PRIMARIA - ALEMÁN' ? 'selected' : ''}}>PRIMARIA - ALEMÁN</option>
                      <option {{$docente->especialidad == 'PRIMARIA - ARTÍSTICA' ? 'selected' : ''}}>PRIMARIA - ARTÍSTICA</option>
                      <option {{$docente->especialidad == 'PRIMARIA - DEPORTIVA' ? 'selected' : ''}}>PRIMARIA - DEPORTIVA</option>
                      <option {{$docente->especialidad == 'SECUNDARIA - EXACTAS' ? 'selected' : ''}}>SECUNDARIA - EXACTAS</option>
                      <option {{$docente->especialidad == 'SECUNDARIA - HUMANIDADES' ? 'selected' : ''}}>SECUNDARIA - HUMANIDADES</option>
                      <option {{$docente->especialidad == 'SECUNDARIA - ALEMÁN' ? 'selected' : ''}}>SECUNDARIA - ALEMÁN</option>
                      <option {{$docente->especialidad == 'SECUNDARIA - ARTÍSTICA' ? 'selected' : ''}}>SECUNDARIA - ARTÍSTICA</option>
                      <option {{$docente->especialidad == 'SECUNDARIA - DEPORTIVA' ? 'selected' : ''}}>SECUNDARIA - DEPORTIVA</option>
                      <option {{$docente->especialidad == 'MULTINIVEL - ALEMÁN' ? 'selected' : ''}}>MULTINIVEL - ALEMÁN</option>
                      <option {{$docente->especialidad == 'MULTINIVEL - ARTÍSTICA' ? 'selected' : ''}}>MULTINIVEL - ARTÍSTICA</option>
                      <option {{$docente->especialidad == 'MULTINIVEL - DEPORTIVA' ? 'selected' : ''}}>MULTINIVEL - DEPORTIVA</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">GRADO DE ESTUDIOS (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('gradoEstudios') is-invalid @enderror" name="gradoEstudios" required>
                      <option disabled selected>-SELECCIONAR-</option>
                      <option {{$docente->gradoEstudios == 'LICENCIATURA' ? 'selected' : ''}}>LICENCIATURA</option>
                      <option {{$docente->gradoEstudios == 'MAESTRÍA' ? 'selected' : ''}}>MAESTRÍA</option>
                      <option {{$docente->gradoEstudios == 'DOCTORADO' ? 'selected' : ''}}>DOCTORADO</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">DOMICILIO</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control @error('direccionDomicilio') is-invalid @enderror"
                    name="direccionDomicilio" value="{{old('direccionDomicilio', $docente->direccionDomicilio)}}" placeholder="DOMICILIO" minlength="1" maxlength="50" autofocus>
                  </div>
                  @error('direccionDomicilio')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">SUBDIRECTOR (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idNivelSubdirector" required>
                      <option value="0" selected>NO</option>
                      @foreach ($Niveles as $rowNiveles)
                      @if ($rowNiveles->idNivel == $docente->idNivelSubdirector)
                      <option value="{{$rowNiveles->idNivel}}" selected>{{$rowNiveles->nombreNivel}}</option>
                      @else
                      <option value="{{$rowNiveles->idNivel}}">{{$rowNiveles->nombreNivel}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">COORDINADOR (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="idCoordinacionEncargado" required>
                      <option value="0" selected>NO</option>
                      @foreach ($Coordinaciones as $rowCoordinaciones)
                      @if ($rowCoordinaciones->idCoordinacion == $docente->idCoordinacionEncargado)
                      <option value="{{$rowCoordinaciones->idCoordinacion}}" selected>{{$rowCoordinaciones->nombreCoordinacion}}</option>
                      @else
                      <option value="{{$rowCoordinaciones->idCoordinacion}}">{{$rowCoordinaciones->nombreCoordinacion}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                
              </div>
              
              <a class="btn btn-warning" data-toggle="modal" data-target="#modalUpdate">
                {!! helper_FormatoBotonCRUD(3, 'texto') !!}
              </a>
              <a href="{{route('docentes.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>

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
  @include('layouts.footerStart')
@include('layouts.footerEnd')