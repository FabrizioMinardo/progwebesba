$(document).ready(function () {
    // Inicializar el datepicker con restricciones de fechas
    $("#fecha").datepicker({
        minDate: 0, // Solo permitir fechas a partir de hoy
        maxDate: new Date('November 30, 2024'), // Hasta noviembre de 2024
        beforeShowDay: function (date) {
            return [esDiaFinDeSemana(date.getDay())];
        },
        onSelect: function (dateText, inst) {
            if (!esDiaValido()) {
                mostrarMensajeError("Por favor, selecciona una fecha válida (viernes, sábado o domingo).");
                return;
            }
            actualizarHorarios();
        }
    }).datepicker("option", $.datepicker.regional["es"]);

    // Configuración de horarios para sábados y domingos
    var horariosDisponibles = ["10:00 AM", "2:00 PM"]; // Puedes ajustar los horarios según tus necesidades
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
});
