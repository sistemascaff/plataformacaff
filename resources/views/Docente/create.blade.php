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
            <form class="form-horizontal" action="{{route('docentes.store')}}" method="POST" enctype="multipart/form-data" id="formularioPerfil">
              
              @csrf
              
              <div class="card-body">
                <h3 class="font-weight-bold text-info rounded">DATOS PERSONALES</h3>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">APELLIDO PATERNO</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('apellidoPaterno') is-invalid @enderror"
                      name="apellidoPaterno" id="apellidoPaterno" value="{{old('apellidoPaterno')}}" placeholder="AP. PATERNO" minlength="1" maxlength="50" autofocus>
                  </div>
                  @error('apellidoPaterno')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">APELLIDO MATERNO</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('apellidoMaterno') is-invalid @enderror"
                      name="apellidoMaterno" id="apellidoMaterno" value="{{old('apellidoMaterno')}}" placeholder="AP. MATERNO" minlength="1" maxlength="50">
                  </div>
                  @error('apellidoMaterno')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NOMBRES (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                      name="nombres" id="nombres" value="{{old('nombres')}}" placeholder="NOMBRES" minlength="1" maxlength="50" required>
                  </div>
                  @error('nombres')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CÉDULA IDENTIDAD (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('documentoIdentificacion') is-invalid @enderror"
                      name="documentoIdentificacion" id="documentoIdentificacion" id="documentoIdentificacion" value="{{old('documentoIdentificacion')}}" placeholder="C.I." minlength="1" maxlength="15" required>
                  </div>
                  @error('documentoIdentificacion')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">C.I. COMPLEMENTO</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('documentoComplemento') is-invalid @enderror"
                      name="documentoComplemento" value="{{old('documentoComplemento')}}" placeholder="C.I. COMP." minlength="1" maxlength="10">
                  </div>
                  @error('documentoComplemento')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">C.I. EXPEDIDO (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="documentoExpedido" required>
                      <option {{old('documentoExpedido') == 'COCHABAMBA' ? 'selected' : ''}}>COCHABAMBA</option>
                      <option {{old('documentoExpedido') == 'BENI' ? 'selected' : ''}}>BENI</option>
                      <option {{old('documentoExpedido') == 'CHUQUISACA' ? 'selected' : ''}}>CHUQUISACA</option>
                      <option {{old('documentoExpedido') == 'LA PAZ' ? 'selected' : ''}}>LA PAZ</option>
                      <option {{old('documentoExpedido') == 'ORURO' ? 'selected' : ''}}>ORURO</option>
                      <option {{old('documentoExpedido') == 'PANDO' ? 'selected' : ''}}>PANDO</option>
                      <option {{old('documentoExpedido') == 'POTOSI' ? 'selected' : ''}}>POTOSI</option>
                      <option {{old('documentoExpedido') == 'SANTA CRUZ' ? 'selected' : ''}}>SANTA CRUZ</option>
                      <option {{old('documentoExpedido') == 'TARIJA' ? 'selected' : ''}}>TARIJA</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">FECHA DE NACIMIENTO (*)</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control @error('fechaNacimiento') is-invalid @enderror"
                      name="fechaNacimiento" id="fechaNacimiento" value="{{old('fechaNacimiento',date("Y-m-d"))}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">SEXO (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
                      <option {{old('sexo') == 'MASCULINO' ? 'selected' : ''}}>MASCULINO</option>
                      <option {{old('sexo') == 'FEMENINO' ? 'selected' : ''}}>FEMENINO</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">IDIOMA (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('idioma') is-invalid @enderror" name="idioma" required>
                      <option selected>ESPAÑOL</option>
                      <option {{old('idioma') == 'ALEMÁN' ? 'selected' : ''}}>ALEMÁN</option>
                      <option {{old('idioma') == 'ESPAÑOL-ALEMÁN' ? 'selected' : ''}}>ESPAÑOL-ALEMÁN</option>
                      <option {{old('idioma') == 'ESPAÑOL-INGLÉS' ? 'selected' : ''}}>ESPAÑOL-INGLÉS</option>
                      <option {{old('idioma') == 'INGLÉS' ? 'selected' : ''}}>INGLÉS</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NIVEL I.E. (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('nivelIE') is-invalid @enderror" name="nivelIE" required>
                      <option selected>NINGUNO</option>
                      <option {{old('nivelIE') == 'A1' ? 'selected' : ''}}>A1</option>
                      <option {{old('nivelIE') == 'A2' ? 'selected' : ''}}>A2</option>
                      <option {{old('nivelIE') == 'B1' ? 'selected' : ''}}>B1</option>
                      <option {{old('nivelIE') == 'B2' ? 'selected' : ''}}>B2</option>
                      <option {{old('nivelIE') == 'C1' ? 'selected' : ''}}>C1</option>
                      <option {{old('nivelIE') == 'C2' ? 'selected' : ''}}>C2</option>
                      <option {{old('nivelIE') == 'DSD I' ? 'selected' : ''}}>DSD I</option>
                      <option {{old('nivelIE') == 'DSD II' ? 'selected' : ''}}>DSD II</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CELULAR PERSONAL</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('celularPersonal') is-invalid @enderror"
                      name="celularPersonal" id="celularPersonal" value="{{old('celularPersonal')}}" placeholder="EJ. 72345678" minlength="1" maxlength="20">
                  </div>
                  @error('celularPersonal')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TELEFONO PERSONAL</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('telefonoPersonal') is-invalid @enderror"
                      name="telefonoPersonal" id="telefonoPersonal" value="{{old('telefonoPersonal')}}" placeholder="EJ. 4234567" minlength="1" maxlength="20">
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
                      name="correo" id="correo" value="{{old('correo')}}" placeholder="correo@froebel.edu.bo" minlength="8" maxlength="80" required>
                  </div>
                  @error('correo')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CONTRASEÑA (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('contrasenha') is-invalid @enderror"
                      name="contrasenha" id="contrasenha" value="{{old('contrasenha')}}" placeholder="CONTRASEÑA" minlength="8" maxlength="80" required>
                  </div>
                  @error('contrasenha')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">PIN DE RECUPERACION (*)</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control @error('pinRecuperacion') is-invalid @enderror"
                      name="pinRecuperacion" id="pinRecuperacion" value="{{old('pinRecuperacion')}}" placeholder="12345678" minlength="8" maxlength="8" required>
                  </div>
                  @error('pinRecuperacion')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
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
                <h3 class="font-weight-bold text-info rounded">DATOS DE DOCENTE</h3>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">ESPECIALIDAD (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('especialidad') is-invalid @enderror" name="especialidad" required>
                      <option disabled selected>-SELECCIONAR-</option>
                      <option {{old('especialidad') == 'INICIAL - UNIDOCENTE' ? 'selected' : ''}}>INICIAL - UNIDOCENTE</option>
                      <option {{old('especialidad') == 'INICIAL - ALEMÁN' ? 'selected' : ''}}>INICIAL - ALEMÁN</option>
                      <option {{old('especialidad') == 'INICIAL - ARTÍSTICA' ? 'selected' : ''}}>INICIAL - ARTÍSTICA</option>
                      <option {{old('especialidad') == 'INICIAL - DEPORTIVA' ? 'selected' : ''}}>INICIAL - DEPORTIVA</option>
                      <option {{old('especialidad') == 'PRIMARIA - UNIDOCENTE' ? 'selected' : ''}}>PRIMARIA - UNIDOCENTE</option>
                      <option {{old('especialidad') == 'PRIMARIA - ALEMÁN' ? 'selected' : ''}}>PRIMARIA - ALEMÁN</option>
                      <option {{old('especialidad') == 'PRIMARIA - ARTÍSTICA' ? 'selected' : ''}}>PRIMARIA - ARTÍSTICA</option>
                      <option {{old('especialidad') == 'PRIMARIA - DEPORTIVA' ? 'selected' : ''}}>PRIMARIA - DEPORTIVA</option>
                      <option {{old('especialidad') == 'SECUNDARIA - EXACTAS' ? 'selected' : ''}}>SECUNDARIA - EXACTAS</option>
                      <option {{old('especialidad') == 'SECUNDARIA - HUMANIDADES' ? 'selected' : ''}}>SECUNDARIA - HUMANIDADES</option>
                      <option {{old('especialidad') == 'SECUNDARIA - ALEMÁN' ? 'selected' : ''}}>SECUNDARIA - ALEMÁN</option>
                      <option {{old('especialidad') == 'SECUNDARIA - ARTÍSTICA' ? 'selected' : ''}}>SECUNDARIA - ARTÍSTICA</option>
                      <option {{old('especialidad') == 'SECUNDARIA - DEPORTIVA' ? 'selected' : ''}}>SECUNDARIA - DEPORTIVA</option>
                      <option {{old('especialidad') == 'MULTINIVEL - ALEMÁN' ? 'selected' : ''}}>MULTINIVEL - ALEMÁN</option>
                      <option {{old('especialidad') == 'MULTINIVEL - ARTÍSTICA' ? 'selected' : ''}}>MULTINIVEL - ARTÍSTICA</option>
                      <option {{old('especialidad') == 'MULTINIVEL - DEPORTIVA' ? 'selected' : ''}}>MULTINIVEL - DEPORTIVA</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">GRADO DE ESTUDIOS (*)</label>
                  <div class="col-sm-10">
                    <select class="form-control @error('gradoEstudios') is-invalid @enderror" name="gradoEstudios" required>
                      <option disabled selected>-SELECCIONAR-</option>
                      <option {{old('gradoEstudios') == 'LICENCIATURA' ? 'selected' : ''}}>LICENCIATURA</option>
                      <option {{old('gradoEstudios') == 'MAESTRÍA' ? 'selected' : ''}}>MAESTRÍA</option>
                      <option {{old('gradoEstudios') == 'DOCTORADO' ? 'selected' : ''}}>DOCTORADO</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">DOMICILIO (*)</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('direccionDomicilio') is-invalid @enderror"
                      name="direccionDomicilio" value="{{old('direccionDomicilio')}}" placeholder="DOMICILIO" minlength="1" maxlength="250">
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
                      @if ($rowNiveles->idNivel == $idSelect)
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
                      @if ($rowCoordinaciones->idCoordinacion == $idSelect)
                      <option value="{{$rowCoordinaciones->idCoordinacion}}" selected>{{$rowCoordinaciones->nombreCoordinacion}}</option>
                      @else
                      <option value="{{$rowCoordinaciones->idCoordinacion}}">{{$rowCoordinaciones->nombreCoordinacion}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-success">{!! helper_FormatoBotonCRUD(5, 'texto') !!}</button>
              <a href="{{route('docentes.index')}}" class="btn btn-secondary">{!! helper_FormatoBotonCRUD(6, 'texto') !!}</a>
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