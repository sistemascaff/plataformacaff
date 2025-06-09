<script type="text/javascript">
    // Este script se encarga de gestionar el préstamo de libros.
    // Verifica si la ruta actual es 'prestamoslibros/crear' para aplicar el script.
    @if (request()->is('prestamoslibros/crear'))
        // Variable para obtener el formato del botón para eliminar un estudiante como String.
        var btnDeleteString = '{!! helper_FormatoBotonCRUD(4, 'icono') !!}';

        if (document.getElementById('addBookLendingForm')) {
            var TableArrayIDs = [];
            //Oculta el div con la animación de carga.
            $('#cargando').hide();
        }

        $(document).ready(function() {
            $('#dataTable').on('click', '.anhadir-lista', function() {
                var idLibro = $(this).data('id');
                var codigoLibro = $(this).data('codigo');
                var nombreLibro = $(this).data('titulo');
                var nombreAutor = $(this).data('autor');
                if (TableArrayIDs.includes(idLibro)) {
                    alert('¡El libro seleccionado ya está en la lista!');
                } else {
                    TableArrayIDs.push(parseInt(idLibro));
                    $('#prestamoLibroTable tbody').append(
                        '<tr>' +
                        '<td>' + codigoLibro + '</td>' +
                        '<td>' + nombreLibro + '</td>' +
                        '<td>' + nombreAutor + '</td>' +
                        '<td>' +
                        '<div class="btn-group">' +
                        '<a class="btn btn-danger quitar-libro" data-idlibro="' +
                        idLibro + '">' +
                        btnDeleteString +
                        '</a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>'
                    );
                }
            });
            $('#prestamoLibroTable').on('click', '.quitar-libro', function() {
                var idLibro = $(this).data('idlibro');
                var fila = this.parentNode.parentNode;
                fila.parentNode.remove(fila);
                var index = TableArrayIDs.findIndex(num => num === idLibro);
                if (index !== -1) {
                    TableArrayIDs.splice(index, 1);
                }
            });
            $('#addBookLendingForm').on('submit', function(event) {
                event.preventDefault();
                // Recupera los valores necesarios para envíar al formulario.
                var idPersona = parseInt(document.getElementById('select2').value);
                var celular = parseInt(document.getElementById('celular').value);
                isNaN(celular) ? celular = 0 : celular = celular;
                var _token = document.getElementById('_token').value;
                var fechaDevolucion = document.getElementById('fechaDevolucion').value;
                var idLibro = TableArrayIDs;
                $('#cargando').show();
                // Enviar una solicitud AJAX al servidor para eliminar al Estudiante de la lista de Integrantes
                if (TableArrayIDs.length > 0 && idPersona) {
                    jQuery.ajax({
                        url: "{{ route('librosprestamos.store') }}",
                        data: {
                            _token: _token,
                            idPersona: idPersona,
                            celular: celular,
                            fechaDevolucion: fechaDevolucion,
                            idLibro: idLibro
                        },
                        method: 'POST',
                        success: function(response) {
                            alert(response.message);
                            if(response.redireccion){
                                window.location.replace(response.redireccion);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        },
                        complete: function() {
                            // Al terminar la solicitud, vuelve a ocultar la animación de carga.
                            $('#cargando').hide();
                        }
                    });
                }
                else{
                    if(!idPersona){
                        alert("¡Por favor seleccione a una persona!");
                    }
                    else{
                        alert("¡Por favor seleccione por lo menos 1 libro!");
                    }
                    $('#cargando').hide();
                }
            });
        });
    @endif
</script>