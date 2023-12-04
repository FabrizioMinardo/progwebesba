<?php
// Verificar si se ha enviado el formulario de asistencia a los eventos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha = $_POST["fecha"];

     // Validar que los campos no estén vacíos
     if (empty($nombre) || empty($apellido) || empty($fecha)) {
        echo "Por favor, completa todos los campos del formulario.";
        header("refresh:2;url=asistirEvento.html");
        exit;  // Salir del script
    }

     // Convertir la fecha al formato MySQL
     $fechaFormateada = DateTime::createFromFormat('m/d/Y', $fecha);

     if ($fechaFormateada === false) {
        // Manejar el caso de error en la conversión de fecha
        echo "Error al procesar la fecha.";
        exit;  // Salir del script
    }

    // Variables de la conexión a la DB
    $mysqli = new mysqli("localhost", "root", "", "programacion web");

    // Verificamos la conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

       // Consulta para verificar duplicados
       $consultaDuplicados = "SELECT COUNT(*) as total FROM participantes WHERE NombreParticipante = '$nombre' AND ApellidoParticipante = '$apellido'";

       $resultadoDuplicados = $mysqli->query($consultaDuplicados);
   
       // Verificar si hay duplicados
       if ($resultadoDuplicados->fetch_assoc()["total"] > 0) {
           echo "El participante ya está registrado.";
           header("refresh:2;url=asistirEvento.html");
           exit;  // Salir del script
       }

    // Ejecutamos consulta SQL en MySQL
    $query = "INSERT INTO participantes (NombreParticipante, ApellidoParticipante, FechaParticipante) VALUES ('$nombre', '$apellido', '" . $fechaFormateada->format('Y-m-d') . "')";

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
