<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('usuarios.index')}}" class="brand-link">
    <img src="{{URL::to('/')}}/img/logo.png" alt="PLATAFORMA CAFF" class="brand-image img-circle">
    <span class="brand-text font-weight-light">PLATAFORMA CAFF</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <a href="{{route('personas.profile')}}">
        <img src="{{URL::to('/')}}/img/user.png" class="img-circle elevation-2" alt="{{session('correo')}}">
        </a>
      </div>
      <div class="info">
        <a href="{{route('usuarios.index')}}" class="d-block">{{session('correo')}}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fa fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item {{ request()->is('usuarios*') ? 'menu-open' : '' }}">
          <a href="" class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-user"></i>
            <p>
              USUARIOS
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('usuarios.index')}}" class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}">
                <i class="fa fa-home nav-icon"></i>
                <p>Inicio </p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('estudiantes*') ? 'menu-open' : 
            (request()->is('profesores*') ? 'menu-open' : '')
          }}">
          <a href="" class="nav-link {{ request()->is('estudiantes*') ? 'active' : 
              (request()->is('profesores*') ? 'active' : '')
            }}">
            <i class="nav-icon fa fa-male"></i>
            <p>
              PERFILES
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('profesores.index')}}" class="nav-link {{ request()->is('profesores*') ? 'active' : '' }}">
                <i class="fa fa-users nav-icon"></i>
                <p>Profesores</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('estudiantes.index')}}" class="nav-link {{ request()->is('estudiantes*') ? 'active' : '' }}">
                <i class="fa fa-users nav-icon"></i>
                <p>Estudiantes</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('campos*') ? 'menu-open' : 
            (request()->is('areas*') ? 'menu-open' : 
              (request()->is('materias*') ? 'menu-open' : 
                (request()->is('aulas*') ? 'menu-open' : 
                  (request()->is('gestiones*') ? 'menu-open' : 
                    (request()->is('periodos*') ? 'menu-open' : 
                      (request()->is('dimensiones*') ? 'menu-open' : 
                        (request()->is('coordinaciones*') ? 'menu-open' : 
                          (request()->is('asignaturas*') ? 'menu-open' : 
                            (request()->is('unidades*') ? 'menu-open' : 
                              (request()->is('silabos*') ? 'menu-open' : '')))))))))) 
          }}">
          <a href="" class="nav-link {{ request()->is('campos*') ? 'active' : 
              (request()->is('areas*') ? 'active' : 
                (request()->is('materias*') ? 'active' : 
                  (request()->is('aulas*') ? 'active' : 
                    (request()->is('gestiones*') ? 'active' : 
                      (request()->is('periodos*') ? 'active' : 
                        (request()->is('dimensiones*') ? 'active' : 
                          (request()->is('coordinaciones*') ? 'active' : 
                            (request()->is('asignaturas*') ? 'active' : 
                              (request()->is('unidades*') ? 'active' : 
                                (request()->is('silabos*') ? 'active' : '')))))))))) 
            }}">
            <i class="nav-icon fa fa-th-list"></i>
            <p>
              CAMPOS
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('gestiones.index')}}" class="nav-link {{ request()->is('gestiones*') ? 'active' : '' }}">
                <i class="fa fa-key nav-icon"></i>
                <p>GESTIONES</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('periodos.index')}}" class="nav-link {{ request()->is('periodos*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>PERIODOS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('dimensiones.index')}}" class="nav-link {{ request()->is('dimensiones*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>DIMENSIONES</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('campos.index')}}" class="nav-link {{ request()->is('campos*') ? 'active' : '' }}">
                <i class="fa fa-key nav-icon"></i>
                <p>CAMPOS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('areas.index')}}" class="nav-link {{ request()->is('areas*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>AREAS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('materias.index')}}" class="nav-link {{ request()->is('materias*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>MATERIAS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('asignaturas.index')}}" class="nav-link {{ request()->is('asignaturas*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>ASIGNATURAS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('unidades.index')}}" class="nav-link {{ request()->is('unidades*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>UNIDADES</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('silabos.index')}}" class="nav-link {{ request()->is('silabos*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>SILABOS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('coordinaciones.index')}}" class="nav-link {{ request()->is('coordinaciones*') ? 'active' : '' }}">
                <i class="fa fa-key nav-icon"></i>
                <p>COORDINACIONES</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('aulas.index')}}" class="nav-link {{ request()->is('aulas*') ? 'active' : '' }}">
                <i class="fa fa-key nav-icon"></i>
                <p>AULAS</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('niveles*') ? 'menu-open' : 
          (request()->is('grados*') ? 'menu-open' : 
            (request()->is('cursos*') ? 'menu-open' : 
              (request()->is('paralelos*') ? 'menu-open' : '')))
        }}">
          <a href="" class="nav-link {{ request()->is('niveles*') ? 'active' : 
            (request()->is('grados*') ? 'active' : 
              (request()->is('cursos*') ? 'active' : 
                (request()->is('paralelos*') ? 'active' : '')))
          }}">
            <i class="nav-icon fa fa-sitemap"></i>
            <p>
              NIVELES
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('niveles.index')}}" class="nav-link {{ request()->is('niveles*') ? 'active' : '' }}">
                <i class="fa fa-key nav-icon"></i>
                <p>NIVELES</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('grados.index')}}" class="nav-link {{ request()->is('grados*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>GRADOS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('paralelos.index')}}" class="nav-link {{ request()->is('paralelos*') ? 'active' : '' }}">
                <i class="fa fa-key nav-icon"></i>
                <p>PARALELOS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('cursos.index')}}" class="nav-link {{ request()->is('cursos*') ? 'active' : '' }}">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>CURSOS</p>
              </a>
            </li>
          </ul>
        </li>
        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>