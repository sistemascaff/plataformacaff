<script type="text/javascript">
    $(function() {
        $("#dataTable-detalle").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 10,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-detalle_wrapper .row:eq(0)');

        $("#dataTable-cantidad-general").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 50,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-cantidad-general_wrapper .row:eq(0)');

        $("#dataTable-cantidad-primaria").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 25,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-cantidad-primaria_wrapper .row:eq(0)');

        $("#dataTable-cantidad-secundaria").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 25,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-cantidad-secundaria_wrapper .row:eq(0)');

        $("#dataTable-cantidad-otros").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 10,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-cantidad-otros_wrapper .row:eq(0)');

        $("#dataTable-cantidad-persona").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 10,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-cantidad-persona_wrapper .row:eq(0)');

        $("#dataTable-cantidad-libro").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 10,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-cantidad-libro_wrapper .row:eq(0)');

        $("#dataTable-cantidad-categoria").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 10,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-cantidad-categoria_wrapper .row:eq(0)');
        
        $("#dataTable-cantidad-deuda-persona").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "colReorder": true,
            "order": [],
            "pageLength": 10,
            "buttons": ["copy", "csv", "excel", "pdf", "colvis", "searchBuilder"]
        }).buttons().container().appendTo('#dataTable-cantidad-deuda-persona_wrapper .row:eq(0)');
    });
</script>
