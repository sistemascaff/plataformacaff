<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{helper_tituloPagina()}} | {{$headTitle}}</title>
  <!-- Icono -->
  <link rel="icon" type="image/x-icon" href="{{URL::to('/')}}/public/favicon.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL::to('/')}}/public/AdminLTE/plugins/font-awesome/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-colreorder/css/colReorder.bootstrap4.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-searchbuilder/css/searchBuilder.bootstrap4.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.css" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL::to('/')}}/public/AdminLTE/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/custom.css">
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    @include('Layouts.navigationBarLeft')
    @include('Layouts.navigationBarRight')

  </nav>
  <!-- /.navbar -->
  
@include('Layouts.sidebar')