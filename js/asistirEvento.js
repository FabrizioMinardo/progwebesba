$(document).ready(function () {
    // Inicializar el datepicker
    $("#fecha").datepicker();

    // Función para validar el formulario al enviar
    $("#asistirForm").submit(function (event) {
        // Evitar que el formulario se envíe automáticamente
        event.preventDefault();

        // Realizar validaciones aquí
        if (validarFormulario()) {
            // Enviar el formulario si es válido
            enviarFormulario();
        }
    });

    // Función para validar el formulario
    function validarFormulario() {
        // Obtener los valores de los campos
        var nombre = $("#nombre").val();
        var apellido = $("#apellido").val();
        var fecha = $("#fecha").val();

        // Realizar las validaciones necesarias
        if (nombre === "" || apellido === "") {
            mostrarMensajeError("Por favor, completa todos los campos del formulario.");
            return false; // El formulario no es válido
        }

        // Validar la fecha
        if (!validarFecha(fecha)) {
            mostrarMensajeError("Por favor, selecciona una fecha válida.");
            return false; // El formulario no es válido
        }

        // Puedes agregar más validaciones según tus necesidades

        return true; // El formulario es válido
    }

    // Función para validar la fecha
    function validarFecha(fecha) {
        // Puedes implementar una lógica más avanzada para validar la fecha si es necesario
        return fecha !== "";
    }

    // Función para enviar el formulario
    function enviarFormulario() {
        // Aquí puedes agregar lógica para enviar el formulario, por ejemplo, a través de AJAX
        // También puedes mostrar un mensaje de confirmación, redirigir a otra página, etc.
        $("#mensaje-asistencia").html('<p class="text-success">¡Gracias por confirmar tu asistencia!</p>').show();
        
        // Puedes realizar acciones adicionales aquí después de enviar el formulario
    }

    // Función para mostrar mensajes de error
    function mostrarMensajeError(mensaje) {
        $("#mensaje-asistencia").html('<p class="text-danger">' + mensaje + '</p>').show();
    }
});
