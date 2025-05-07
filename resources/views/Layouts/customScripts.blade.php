<script>
    @if (request()->is('asignaturas/*'))
        // Inicio del conjunto de métodos para gestionar via AJAX la adición y eliminación de un estudiante en las Asignaturas (En caso de que sea una Asignatura de Bloque mixto).
        // Como se observa, se procura usar un if de blade.php (a parte de JavaScript) para invocar todo el código para evitar saturar las páginas de código que no se utilizará en todos los módulos.

        // Variable para obtener el formato del botón para eliminar un estudiante como String.
        var btnDeleteString = '{!! helper_FormatoBotonCRUD(4, 'icono') !!}';

        // Condicional para manejar e invocar los métodos necesarios para añadir y eliminar a los estudiantes de las Asignaturas.
        if (document.getElementById('addMemberForm')) {
            //Oculta el div con la animación de carga.
            $('#cargando').hide();
            // Variable para almacenar en un array todos los idEstudiante Integrantes de la Asignatura.
            var TableArrayIDs = [];
            // Método para recorrer la tabla de Integrantes y almacenar los idEstudiante.
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

                // Recorre cada fila y asigna un nuevo valor al atributo data-iterador
                filasTabla.forEach((fila, indice) => {
                    const enlace = fila.querySelector('.eliminar-integrante');
                    if (enlace) {
                        enlace.setAttribute('data-iterador', indice);
                    }
                });
            }

            // Se invoca al método al cargar la página para almacenar la información.
            llenarTableArrayIDs();

            //Método para añadir un estudiante a la tabla de Integrantes.
            $(document).ready(function() {
                $('#addMemberForm').on('submit', function(event) {
                    event.preventDefault();
                    // Recupera los valores necesarios para envíar al formulario.
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
                                    //En caso de éxito, añade el registro a la tabla.
                                    $('#integrantesTable tbody').append(
                                        '<tr>' +
                                        '<td>' + response.nombreCurso + '</td>' +
                                        '<td>' + response.nombreEstudiante + '</td>' +
                                        '<td>' +
                                        '<div class="btn-group">' +
                                        '<a class="btn btn-danger eliminar-integrante" data-toggle="modal" data-target="#modalDeleteMember" data-iterador="' +
                                        (TableArrayIDs.length + 1) +
                                        '" data-idestudiante="' +
                                        response.idEstudiante + '" data-estudiante="' +
                                        response
                                        .nombreEstudiante + '">' +
                                        btnDeleteString +
                                        '</a>' +
                                        '</div>' +
                                        '</td>' +
                                        '</tr>'
                                    );
                                    // Añadir el idEstudiante al array.
                                    TableArrayIDs.push(parseInt(idEstudianteSeleccionado));
                                    // Actualiza la cantidad de Integrantes.
                                    document.getElementById('totalRegistros').innerText =
                                        "Número de Integrantes: " + TableArrayIDs.length;
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
                    }
                });
            });

            //Método para eliminar un estudiante de la tabla de Integrantes.
            $(document).ready(function() {
                $('#deleteMemberForm').on('submit', function(event) {
                    event.preventDefault();
                    // Recupera los valores necesarios para envíar al formulario.
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
                            // En caso de éxito se oculta el modal, se elimina el registro o fila de la tabla, se vuelve a llenar el array de ID's y se actualiza el número de registros del array.
                            $('#modalDeleteMember').modal('hide');
                            document.getElementById("integrantesTable").deleteRow(document
                                .getElementById('iterador').value);
                            llenarTableArrayIDs();
                            document.getElementById('totalRegistros').innerText =
                                "Número de Integrantes: " + TableArrayIDs.length;
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        },
                        complete: function() {
                            // Al terminar la solicitud, vuelve a ocultar la animación de carga.
                            $('#cargando').hide();
                        }
                    });
                });
            });
            // Función para gestionar el modal cada que el usuario presione el botón de eliminar un Integrante (Estudiante).
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
        //Si el elemento con el id 'btnRefresh' existe, crea un evento onClick para obtener el idCurso y enviarlo en el formulario para refrescar la lista de integrantes.
        if (document.getElementById('btnRefresh')) {
            $(document).ready(function() {
                $('#btnRefresh').on('click', function() {
                    var id = document.getElementById('idCurso').value;
                    $('#modalRefreshMembers').find('input[id="refreshIdCurso"]').val(id);
                });
            });
        }

        //Si el elemento <select> con el id 'idCurso' existe, se entiende que el tipo de bloque es de un solo curso, se recupera el nombre de curso de la primera Celda de la tabla,
        //luego se compara con cada opción del <select>, y finalmente se selecciona la opción que sea igual al valor recuperado.
        if (document.getElementById('idCurso')) {
            var primeraCelda = document.querySelector("table#integrantesTable tr td:first-child");
            const selectElement = document.getElementById("idCurso");
            for (let i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].text === primeraCelda.innerText) {
                    selectElement.options[i].selected = true;
                    break; // Una vez que se ha encontrado la coincidencia, se detiene el bucle
                }
            }
        }
        // Fin del conjunto de métodos para gestionar via AJAX la adición y eliminación de un estudiante en las Asignaturas (En caso de que sea una Asignatura de Bloque mixto).
    @endif

    @if (request()->is('prestamoslibros/*'))
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
