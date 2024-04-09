</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Versión</b> {{helper_versionApp()}}
  </div>
  <strong>Copyright &copy; 2024 CAFF. Todos los derechos reservados.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-colreorder/js/dataTables.colReorder.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-colreorder/js/colReorder.bootstrap4.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-searchbuilder/js/dataTables.searchBuilder.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-searchbuilder/js/searchBuilder.bootstrap4.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/jszip/jszip.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.js"></script>
<!-- AdminLTE App -->
<script src="{{helper_retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- Script específico de los atributos de los dataTables -->
<script>
  $(function(){
    $("#dataTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": true,
      "colReorder": true,
      "order": [],
      "pageLength": 50,
      "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
    }).buttons().container().appendTo('#dataTable_wrapper .row:eq(0)');
  });
</script>
<!-- Script específico para invocar un modal para eliminar un registro desde un dataTable -->
<script>
  $(document).ready(function() {
    $('#dataTable').on('click', '.eliminar-registro', function() {
          var id = $(this).data('id');
          var nombre = $(this).data('nombre');
          $('#modalDelete').find('input[id="id"]').val(id);
          $('#modalDelete').find('#nombre').text(nombre);
      });
  });
</script>

</body>
</html>
