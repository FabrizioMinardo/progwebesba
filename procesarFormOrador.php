<?php
// Verificar si se ha enviado el formulario de asistencia a los eventos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $tema = $_POST["tema"];

     // Verificar campos vacíos
     if (empty($nombre) || empty($apellido) || empty($tema)) {
        echo "Por favor, completa todos los campos del formulario.";
        header("refresh:2;url=index.html");
        exit;  // Salir del script
    }

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

        // Verificar si el orador ya está registrado
        $verificarQuery = "SELECT * FROM oradoresAnotados WHERE NombreOradorAnotado = '$nombre' AND ApellidoOradorAnotado = '$apellido'";
        $resultado = $mysqli->query($verificarQuery);

        if ($resultado->num_rows > 0) {
            echo "Error. El orador ya está registrado.";
            header("refresh:2;url=index.html");
        } else {
            // Ejecutamos consulta SQL en MySQL
            $query = "INSERT INTO oradoresAnotados (NombreOradorAnotado, ApellidoOradorAnotado, DescripcionOradorAnotado) VALUES ('$nombre', '$apellido', '$tema')";

            // Ejecutar la consulta y verificar si fue exitosa
            if ($mysqli->query($query) === TRUE) {
                echo "¡Orador registrado correctamente!";
                // Redirigir a la página principal después de 2 segundos
                header("refresh:2;url=index.html");
            } else {
                // Si hay un error de duplicación u otro error
                echo "Error al guardar los datos: " . $mysqli->error;
                header("refresh:2;url=index.html");
            }
        }

        // Cerrar la conexión a la base de datos
        $mysqli->close();
    }
}
?>
