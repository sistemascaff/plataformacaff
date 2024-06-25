//Script dependiente de DataTables
$(function () {
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
//Script específico para invocar un modal para eliminar un registro desde un dataTable
$(document).ready(function () {
    $('#dataTable').on('click', '.eliminar-registro', function () {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        $('#modalDelete').find('input[id="id"]').val(id);
        $('#modalDelete').find('#nombre').text(nombre);
    });
});
//Script específico para formatear ciertos campos de los Formularios de Perfiles
if (document.getElementById('formularioPerfil')) {
    // Variables globales
    const nombresInput = document.getElementById('nombres');
    const apellidoPaternoInput = document.getElementById('apellidoPaterno');
    const apellidoMaternoInput = document.getElementById('apellidoMaterno');
    const documentoIdentificacionInput = document.getElementById('documentoIdentificacion');
    const fechaNacimientoInput = document.getElementById('fechaNacimiento');
    const correoInput = document.getElementById('correo');

    // Función para generar correo electrónico
    function generarCorreo() {
        const nombres = nombresInput.value.trim();
        const apellidoPaterno = apellidoPaternoInput.value.trim().replace(/\s+/g, "");
        const apellidoMaterno = apellidoMaternoInput.value.trim().replace(/\s+/g, "");
        const cedulaIdentidad = documentoIdentificacionInput.value.trim();
        const apellido = apellidoPaterno || apellidoMaterno;
        const correo = nombres.slice(0, 1).toLowerCase() + '.' + apellido.toLowerCase() + '.' + cedulaIdentidad
            .slice(-3) + '@froebel.edu.bo';
        correoInput.value = correo;
    }

    // Event listeners
    fechaNacimientoInput.addEventListener('blur', function () {
        const formattedDate = this.value.split('-').reverse().join('');
        const contrasenha = documentoIdentificacionInput.value + '+' + formattedDate.slice(0, 2);
        document.getElementById('contrasenha').value = contrasenha;
        document.getElementById('pinRecuperacion').value = formattedDate;
    });

    documentoIdentificacionInput.addEventListener('blur', function () {
        const formattedDate = fechaNacimientoInput.value.split('-').reverse().join('');
        const contrasenha = documentoIdentificacionInput.value + '+' + formattedDate.slice(0, 2);
        document.getElementById('contrasenha').value = contrasenha;
        generarCorreo();
    });

    nombresInput.addEventListener('blur', function () {
        generarCorreo();
    });

    apellidoPaternoInput.addEventListener('blur', function () {
        generarCorreo();
    });

    apellidoMaternoInput.addEventListener('blur', function () {
        generarCorreo();
    });
}
//Script dependiente de Select2
$(document).ready(function () {
    $('#select2').select2({
        language: {
            placeholder: function () {
                return "Selecciona una opción";
            },
            noResults: function () {
                return "No se encontraron resultados";
            },
            searching: function () {
                return "Buscando...";
            }
        }
    });
});
