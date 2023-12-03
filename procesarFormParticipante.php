<?php
// Verificar si se ha enviado el formulario de asistencia a los eventos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha = $_POST["fecha"];

     // Convertir la fecha al formato MySQL
     $fechaFormateada = DateTime::createFromFormat('m/d/Y', $fecha)->format('Y-m-d');

    // Variables de la conexión a la DB
    $mysqli = new mysqli("localhost", "root", "", "programacion web");

    // Verificamos la conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Ejecutamos consulta SQL en MySQL
    $query = "INSERT INTO participantes (NombreParticipante, ApellidoParticipante, FechaParticipante) VALUES ('$nombre', '$apellido', '$fechaFormateada')";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($mysqli->query($query) === TRUE) {
        echo "¡Datos guardados correctamente!";
        header("refresh:2;url=asistirEvento.html");
    } else {
        // Si hay un error de duplicación, puedes manejarlo aquí
        if ($mysqli->errno == 1062) {
            echo "El participante ya está registrado.";
            header("refresh:2;url=asistirEvento.html");
        } else {
            echo "Error al guardar los datos: " . $mysqli->error;
            header("refresh:2;url=asistirEvento.html");
        }
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();
}
?>
