// Definir la fecha actual
var fechaActual = new Date();

$(document).ready(function () {
    // Elemento para mostrar mensaje de fecha incorrecta
    var mensajeFechaIncorrecta = $("<p class='text-danger'>Elige una fecha válida (viernes, sábado o domingo).</p>");
    
    // Insertar mensaje en el DOM
    mensajeFechaIncorrecta.insertAfter("#fecha");

    // Ocultar el mensaje inicialmente
    mensajeFechaIncorrecta.hide();

     // Inicializar el datepicker con restricciones de fechas
     $("#fecha").datepicker({
        minDate: fechaActual, // Solo permitir fechas a partir de hoy
        beforeShowDay: function (date) {
            var diaSemana = date.getDay();
            var esFinDeSemana = diaSemana === 5 || diaSemana === 6 || diaSemana === 0;
            var esFechaFutura = date >= fechaActual;
            return [esFinDeSemana && esFechaFutura, ''];
        },
        onSelect: function (dateText, inst) {
            if (!esDiaValido()) {
                mostrarMensajeFechaIncorrecta(true);
            } else {
                mostrarMensajeFechaIncorrecta(false);
            }
            // Resto de tu código onSelect
            console.log('Fecha seleccionada:', dateText);
        }
    }).datepicker("option", $.datepicker.regional["es"]);

    // Configuración de horarios para sábados y domingos
    var horariosDisponibles = ["10:00 AM", "2:00 PM"];
    var horariosSelect = $("#horario");

    // Llamar a la función de actualización cuando se carga la página
    actualizarHorarios();

    // Función para validar el formulario al enviar
    $("#asistirForm").submit(function (event) {
        event.preventDefault();
        if (validarFormulario()) {
            enviarFormulario();
        }
    });

    // Función para enviar el formulario
    function enviarFormulario() {
        $("#mensaje-asistencia").html('<p class="text-success">¡Gracias por confirmar tu asistencia!</p>').show();
        // Puedes realizar acciones adicionales aquí después de enviar el formulario
    }

    // Función para actualizar los horarios disponibles según el día seleccionado
    function actualizarHorarios() {
        var selectedDate = $("#fecha").datepicker("getDate");

        if (!selectedDate) {
            return;
        }

        var selectedDay = selectedDate.getDay();

        if (esDiaFinDeSemana(selectedDay)) {
            habilitarHorarios();
        } else {
            deshabilitarHorarios();
        }
    }

    // Función para validar el formulario
    function validarFormulario() {
        var nombre = $("#nombre").val();
        var apellido = $("#apellido").val();
        var horario = $("#horario").val();

        if (nombre === "" || apellido === "" || horario === "") {
            mostrarMensajeError("Por favor, completa todos los campos del formulario.");
            return false;
        }

        if (!esDiaValido()) {
            mostrarMensajeError("Por favor, selecciona una fecha válida (viernes, sábado o domingo).");
            return false;
        }

        // Puedes agregar más validaciones según tus necesidades

        return true;
    }

    // Función para validar que la fecha sea un viernes, sábado o domingo
    function esDiaValido() {
        var selectedDate = $("#fecha").datepicker("getDate");

        if (!selectedDate) {
            return false;
        }

        var selectedDay = selectedDate.getDay();
        return esDiaFinDeSemana(selectedDay);
    }

    // Función para mostrar mensajes de error
    function mostrarMensajeError(mensaje) {
        $("#mensaje-asistencia").html('<p class="text-danger">' + mensaje + '</p>').show();
    }

    // Funciones de ayuda
    function esDiaFinDeSemana(day) {
        return day === 5 || day === 6 || day === 0;
    }

    function habilitarHorarios() {
        horariosSelect.prop('disabled', false);
        horariosSelect.empty();
        for (var i = 0; i < horariosDisponibles.length; i++) {
            horariosSelect.append(new Option(horariosDisponibles[i], horariosDisponibles[i]));
        }
    }

    function deshabilitarHorarios() {
        horariosSelect.prop('disabled', true);
        horariosSelect.empty();
    }

    // Función para mostrar u ocultar el mensaje de fecha incorrecta
    function mostrarMensajeFechaIncorrecta(mostrar) {
        if (mostrar) {
            mensajeFechaIncorrecta.show();
        } else {
            mensajeFechaIncorrecta.hide();
        }
    }
});
