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