<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Programacion web</title>
    <link rel="icon" href="Imagenes/esba logo.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="css\login.css">
</head>

<body>
    <!-- Header -->
    <div id="new-header">
        <div class="header-logo">
            <img src="Imagenes/LOGO BA.png" alt="Logo" class="w-25">
            <h1>CONFERENCIAS B.A</h1>
        </div>
        <div class="header-menu">
            <a href="index.html#carrusel">Conferencias</a>
            <a href="oradores.php">Oradores</a>
            <a href="asistirEvento.html" class="text-warning">¡QUIERO ASISTIR!</a>
        </div>
    </div>

    <?php
    // Variables de la conexión a la DB
    $mysqli = new mysqli("localhost", "root", "", "programacion web");

    // Verificamos la conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Acción de eliminación
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        if ($_POST['action'] == 'eliminar_orador' && isset($_POST['IdOradorAnotado'])) {
            // Obtener el ID del orador a eliminar
            $id_orador = $_POST['IdOradorAnotado'];

            // Ejecutar consulta SQL para eliminar el orador
            $queryEliminar = $mysqli->prepare("DELETE FROM oradoresAnotados WHERE IdOradorAnotado = ?");
            $queryEliminar->bind_param("i", $id_orador);

            if ($queryEliminar->execute()) {
                echo '<script>alert("Orador eliminado correctamente.");</script>';
            } else {
                echo '<script>alert("Error al eliminar el orador: ' . $mysqli->error . '");</script>';
            }

            $queryEliminar->close();
        } elseif ($_POST['action'] == 'editar_orador') {
            // Acción de edición
            $id_orador = $_POST['IdOradorAnotado'];
            $nuevo_nombre = $_POST['nombre'];
            $nuevo_apellido = $_POST['apellido'];
            $nuevo_tema = $_POST['tema'];

            // Verificar que los campos no estén vacíos antes de actualizar la base de datos
            if (!empty($nuevo_nombre) && !empty($nuevo_apellido) && !empty($nuevo_tema)) {
                $queryEditar = $mysqli->prepare("UPDATE oradoresAnotados SET NombreOradorAnotado = ?, ApellidoOradorAnotado = ?, DescripcionOradorAnotado = ? WHERE IdOradorAnotado = ?");
                $queryEditar->bind_param("sssi", $nuevo_nombre, $nuevo_apellido, $nuevo_tema, $id_orador);

                if ($queryEditar->execute()) {
                    echo '<script>alert("Orador editado correctamente.");</script>';
                } else {
                    echo '<script>alert("Error al editar el orador: ' . $mysqli->error . '");</script>';
                }

                $queryEditar->close();
            } else {
                echo '<script>alert("Los campos Nombre, Apellido y Tema no pueden estar vacíos.");</script>';
            }
        }
    }

    // Acción de visualización
    $queryRegistrados = $mysqli->query("SELECT IdOradorAnotado, NombreOradorAnotado, ApellidoOradorAnotado, DescripcionOradorAnotado FROM oradoresAnotados;");

    if (!$queryRegistrados) {
        die("Error en la consulta de oradores registrados: " . $mysqli->error);
    }

    $oradoresRegistrados = [];
    if ($queryRegistrados && $queryRegistrados->num_rows > 0) {
        while ($resultado = $queryRegistrados->fetch_assoc()) {
            $oradoresRegistrados[] = $resultado;
        }
    } else {
        echo "No hay oradores registrados.";
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();
    ?>

    <!-- Mostrar lista de oradores registrados -->
    <ul>
    <h2>LISTADO DE ORADORES DE LA BASE DE DATOS</h1>
        <?php
        foreach ($oradoresRegistrados as $oradorRegistrado) {
        ?>
         
         <li style="margin-bottom: 15px; border: 0.2em solid #ccc; padding: 10px; border-radius: 3px;">
            <span style="font-size: 1.5em; font-weight: bold; color: #fff;">

                <?php
                echo $oradorRegistrado['NombreOradorAnotado'];
                echo " ";
                echo $oradorRegistrado['ApellidoOradorAnotado'];
                echo " va a hablar sobre: ";
                echo $oradorRegistrado['DescripcionOradorAnotado'];
                ?>
                </span>
                <br>
                <span style="font-size: 1.2em; color: #666;">
                <form method="post" action="">
                    <input type="hidden" name="IdOradorAnotado" value="<?php echo $oradorRegistrado['IdOradorAnotado']; ?>">
                    <label for="nombre" style="width: 80px;">Nuevo Nombre:</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $oradorRegistrado['NombreOradorAnotado']; ?>" style="width: 10em;">
                    <label for="apellido" style="width: 80px;">Nuevo Apellido:</label>
                    <input type="text" name="apellido" id="apellido" value="<?php echo $oradorRegistrado['ApellidoOradorAnotado']; ?>" style="width: 10em;">
                    <label for="tema" style="width: 80px;">Nuevo Tema:</label>
                    <input type="text" name="tema" id="tema" value="<?php echo $oradorRegistrado['DescripcionOradorAnotado']; ?>" style="width: 10em;">
                    <button type="submit" name="action" value="editar_orador">Editar</button>
                    <button type="submit" name="action" value="eliminar_orador" onclick="return confirm('¿Estás seguro de que quieres eliminar este orador?');">Eliminar</button>
                </form>
            </li>
        <?php
        }
        ?>
    </ul>
</body>

</html>
