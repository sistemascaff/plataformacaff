<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{helper_tituloPagina()}} | USUARIOS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/font-awesome/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('usuarios.index')}}" class="nav-link">INICIO</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-sign-out"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{session('correo')}}</span>
          <div class="dropdown-divider"></div>
          <a href="{{route('logout')}}" class="dropdown-item text-center">
            <i class="fa fa-sign-out"></i> CERRAR SESIÓN
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('usuarios.index')}}" class="brand-link">
      <img src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}img/logo.png" alt="PLATAFORMA CAFF" class="brand-image img-circle">
      <span class="brand-text font-weight-light">PLATAFORMA CAFF</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}img/user.png" class="img-circle elevation-2" alt="{{session('correo')}}">
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
                PERSONAS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('personas.index')}}" class="nav-link {{ request()->is('personas*') ? 'active' : '' }}">
                  <i class="fa fa-home nav-icon"></i>
                  <p>Inicio </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ request()->is('campos*') ? 'menu-open' : (request()->is('areas*') ? 'menu-open' : '') }}">
            <a href="" class="nav-link {{ request()->is('campos*') ? 'active' : (request()->is('areas*') ? 'active' : '') }}">
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
          </li>

          <li class="nav-item {{ request()->is('niveles*') ? 'menu-open' : 
            (request()->is('grados*') ? 'menu-open' : '')
          }}">
            <a href="" class="nav-link {{ request()->is('niveles*') ? 'active' : 
              (request()->is('grados*') ? 'active' : '')
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
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>