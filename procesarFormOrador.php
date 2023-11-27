<?php
// Verificar si se ha enviado el formulario de asistencia a los eventos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $tema = $_POST["tema"];

    // Verificacion de la longitud del tema
    if (strlen($tema) > 199) {
        echo "Error: El tema no puede tener más de 199 caracteres.";
    } else {
        // Variables de la conexión a la DB
        $mysqli = new mysqli("localhost", "root", "", "programacion web");

        // Verificamos la conexión
        if ($mysqli->connect_error) {
            die("Error de conexión: " . $mysqli->connect_error);
        }

        // Ejecutamos consulta SQL en MySQL
        $query = "INSERT INTO oradoresAnotados (NombreOradorAnotado, ApellidoOradorAnotado, DescripcionOradorAnotado) VALUES ('$nombre', '$apellido', '$tema')";

        // Ejecutar la consulta y verificar si fue exitosa
        if ($mysqli->query($query) === TRUE) {
            echo "¡Orador registrado correctamente!";
        } else {
            // Si hay un error de duplicación, puedes manejarlo aquí
            if ($mysqli->errno == 1062) {
                echo "El orador ya está registrado.";
            } else {
                echo "Error al guardar los datos: " . $mysqli->error;
            }
        }

        // Cerrar la conexión a la base de datos
        $mysqli->close();
    }
}
?>
