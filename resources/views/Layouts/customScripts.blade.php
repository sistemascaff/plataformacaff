<script>
    var btnDeleteString = '{!! helper_FormatoBotonCRUD(4, 'icono') !!}';
    // Manejar el evento de clic en el botón "Añadir Estudiante"
    if (document.getElementById('addMemberForm')) {
        //Oculta el div con la animación de carga.
        $('#cargando').hide();
        //Primero capturamos todos los ID's de la tabla y los almacenamos en un Array.
        var TableArrayIDs = [];
        function llenarTableArrayIDs() {
            TableArrayIDs = [];
            $("table#integrantesTable tr").each(function() {
                var idRow = 0;
                var tableData = $(this).find('td');
                if (tableData.length > 0) {
                    tableData.each(function() {
                        var btnA = $(this).find('a');
                        idRow = parseInt(btnA.data('idestudiante'));
                    });
                    TableArrayIDs.push(idRow);
                }
            });
            
            const filasTabla = document.querySelectorAll('table#integrantesTable tr');
            // Recorrer cada fila y asignar un nuevo valor al atributo data-iterador
            filasTabla.forEach((fila, indice) => {
                const enlace = fila.querySelector('.eliminar-integrante');
                if (enlace) {
                    enlace.setAttribute('data-iterador', indice);
                }
            });
        }

        llenarTableArrayIDs();

        //Método para gestionar la tabla de Integrantes y realizar la inserción.
        $(document).ready(function() {
            $('#addMemberForm').on('submit', function(event) {
                event.preventDefault();
                var idEstudianteSeleccionado = parseInt(document.getElementById('select2').value);
                var _token = document.getElementById('_token').value;
                var idAsignatura = document.getElementById('idAsignatura').value;
                // Verificar si el estudiante ya está en la lista de integrantes
                if (idEstudianteSeleccionado != 0) {
                    if (TableArrayIDs.includes(idEstudianteSeleccionado)) {
                        alert('¡El estudiante seleccionado ya está en la lista!');
                    } else {
                        $('#cargando').show();
                        // Enviar una solicitud AJAX al servidor para agregar al Estudiante a la lista de Integrantes
                        jQuery.ajax({
                            url: "{{ route('asignaturas.addMember') }}",
                            data: {
                                _token: _token,
                                idAsignatura: idAsignatura,
                                idEstudiante: idEstudianteSeleccionado
                            },
                            method: 'POST',
                            success: function(response) {
                                $('#integrantesTable tbody').append(
                                    '<tr>' +
                                    '<td>' + response.nombreCurso + '</td>' +
                                    '<td>' + response.nombreEstudiante + '</td>' +
                                    '<td>' +
                                    '<div class="btn-group">' +
                                    '<a class="btn btn-danger eliminar-integrante" data-toggle="modal" data-target="#modalDeleteMember" data-iterador="' +
                                    (TableArrayIDs.length + 1) + '" data-idestudiante="' +
                                    response.idEstudiante + '" data-estudiante="' +
                                    response
                                    .nombreEstudiante + '">' +
                                    btnDeleteString +
                                    '</a>' +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>'
                                );
                                // Añadir el idEstudiante al array
                                TableArrayIDs.push(parseInt(idEstudianteSeleccionado));
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            },
                            complete: function() {
                                $('#cargando').hide();
                            }
                        });
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#deleteMemberForm').on('submit', function(event) {
                event.preventDefault();
                var idEstudiante = parseInt(document.getElementById('deleteIdEstudiante').value);
                var _token = document.getElementById('_token').value;
                var idAsignatura = document.getElementById('idAsignatura').value;
                $('#cargando').show();
                // Enviar una solicitud AJAX al servidor para eliminar al Estudiante de la lista de Integrantes
                jQuery.ajax({
                    url: "{{ route('asignaturas.deleteMember') }}",
                    data: {
                        _token: _token,
                        idAsignatura: idAsignatura,
                        idEstudiante: idEstudiante
                    },
                    method: 'POST',
                    success: function(response) {
                        $('#modalDeleteMember').modal('hide');
                        document.getElementById("integrantesTable").deleteRow(document.getElementById('iterador').value);
                        llenarTableArrayIDs();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    },
                    complete: function() {
                        $('#cargando').hide();
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#integrantesTable').on('click', '.eliminar-integrante', function() {
                var id = $(this).data('idestudiante');
                var nombre = $(this).data('estudiante');
                var iterador = $(this).data('iterador');
                $('#modalDeleteMember').find('input[id="deleteIdEstudiante"]').val(id);
                $('#modalDeleteMember').find('#nombreEstudiante').text(nombre);
                $('#modalDeleteMember').find('input[id="iterador"]').val(iterador);
            });
        });
    }
</script>
