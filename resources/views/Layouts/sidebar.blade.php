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
        <img src="{{URL::to('/')}}/img/user.png" class="img-circle elevation-2" alt="{{session('correo')}}">
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

        <li class="nav-item {{ request()->is('personas*') ? 'menu-open' : '' }}">
          <a href="" class="nav-link {{ request()->is('personas*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-male"></i>
            <p>
              PERFILES
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('personas.index')}}" class="nav-link {{ request()->is('personas*') ? 'active' : '' }}">
                <i class="fa fa-users nav-icon"></i>
                <p>Estudiantes</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('campos*') ? 'menu-open' : (request()->is('areas*') ? 'menu-open' : (request()->is('materias*') ? 'menu-open' : '')) }}">
          <a href="" class="nav-link {{ request()->is('campos*') ? 'active' : (request()->is('areas*') ? 'active' : (request()->is('materias*') ? 'active' : '')) }}">
            <i class="nav-icon fa fa-th-list"></i>
            <p>
              CAMPOS
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('campos.index')}}" class="nav-link {{ request()->is('campos*') ? 'active' : '' }}">
                <i class="fa fa-th-list nav-icon"></i>
                <p>CAMPOS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('areas.index')}}" class="nav-link {{ request()->is('areas*') ? 'active' : '' }}">
                <i class="fa fa-th-list nav-icon"></i>
                <p>AREAS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('materias.index')}}" class="nav-link {{ request()->is('materias*') ? 'active' : '' }}">
                <i class="fa fa-th-list nav-icon"></i>
                <p>MATERIAS</p>
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
                <i class="fa fa-sitemap nav-icon"></i>
                <p>NIVELES</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('grados.index')}}" class="nav-link {{ request()->is('grados*') ? 'active' : '' }}">
                <i class="fa fa-sitemap nav-icon"></i>
                <p>GRADOS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('paralelos.index')}}" class="nav-link {{ request()->is('paralelos*') ? 'active' : '' }}">
                <i class="fa fa-sitemap nav-icon"></i>
                <p>PARALELOS</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('cursos.index')}}" class="nav-link {{ request()->is('cursos*') ? 'active' : '' }}">
                <i class="fa fa-sitemap nav-icon"></i>
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