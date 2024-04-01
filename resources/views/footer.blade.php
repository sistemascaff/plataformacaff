</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Versión</b> {{versionApp()}}
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
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/jszip/jszip.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="{{retrocederDirectorio($retrocederDirectorioAssets)}}public/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- DataTables specific script -->
<script>
  $(function(){
    $("#dataTable").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true, "order":[],
      "buttons": ["copy", "csv", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
  });
</script>

</body>
</html>