</div>
<!-- /.content-wrapper -->

<!-- Modal Logout -->
<div class="modal fade" id="modalLogout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title font-weight-bold text-info">ATENCIÓN</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="font-weight-bold"><span class="text-info">{{session('correo')}}</span>, ¿Desea cerrar sesión?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancelar</button>
        <a href="{{route('logout')}}" class="btn btn-info">
          <i class="fa fa-sign-out"></i> Si, cerrar sesión
        </a>
      </div>
    </div>
  </div>
</div>


<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Versión</b> {{helper_versionApp()}}
  </div>
  <strong>Copyright &copy; {{date("Y")}} COLEGIO ALEMÁN FEDERICO FROEBEL. Todos los derechos reservados.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-colreorder/js/dataTables.colReorder.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-colreorder/js/colReorder.bootstrap4.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-searchbuilder/js/dataTables.searchBuilder.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-searchbuilder/js/searchBuilder.bootstrap4.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/jszip/jszip.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{URL::to('/')}}/public/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.js"></script>
<!-- AdminLTE App -->
<script src="{{URL::to('/')}}/public/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- CAFF Custom Script -->
<script src="{{URL::to('/')}}/public/custom.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- En caso de incrustar un script específico, realizarlo después de este Layout -->