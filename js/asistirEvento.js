$(document).ready(function () {
    const mensajeFechaIncorrecta = $("<p class='text-danger'>Elige una fecha válida (viernes, sábado o domingo).</p>").insertAfter("#fecha");
    mensajeFechaIncorrecta.hide();

    $("#fecha").datepicker({
        minDate: new Date(),
        beforeShowDay: function (date) {
            return [esDiaFinDeSemana(date.getDay()) && date >= new Date(), ''];
        },
        onSelect: function (dateText, inst) {
            mostrarMensajeFechaIncorrecta(!esDiaValido());
            console.log('Fecha seleccionada:', dateText);
        }
    }).datepicker("option", $.datepicker.regional["es"]);

    $("#asistirForm").submit(function (event) {
        event.preventDefault();
        if (validarFormulario()) {
            enviarFormulario();
        }
    });

    function enviarFormulario() {
        $("#mensaje-asistencia").html('<p class="text-success">¡Gracias por confirmar tu asistencia!</p>').show();
    }

    function validarFormulario() {
        const nombre = $("#nombre").val();
        const apellido = $("#apellido").val();

        if (nombre === "" || apellido === "") {
            mostrarMensajeError("Por favor, completa todos los campos del formulario.");
            return false;
        }

        if (!esDiaValido()) {
            mostrarMensajeError("Por favor, selecciona una fecha válida (viernes, sábado o domingo).");
            return false;
        }

        return true;
    }

    function esDiaValido() {
        const selectedDate = $("#fecha").datepicker("getDate");
        if (!selectedDate) return false;

        return esDiaFinDeSemana(selectedDate.getDay());
    }

    function mostrarMensajeError(mensaje) {
        $("#mensaje-asistencia").html(`<p class="text-danger">${mensaje}</p>`).show();
    }

    function esDiaFinDeSemana(day) {
        return day === 5 || day === 6 || day === 0;
    }

    function mostrarMensajeFechaIncorrecta(mostrar) {
        mostrar ? mensajeFechaIncorrecta.show() : mensajeFechaIncorrecta.hide();
    }
});

