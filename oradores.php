<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Programacion web</title>
    <link rel="icon" href="Imagenes/esba logo.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css\oradores.css">
</head>
<body>
    <!-- Header -->
    <div id="new-header">
        <div class="header-logo">
            <img src="Imagenes/LOGO BA.png" alt="Logo" class="w-25">
            <h1>CONFERENCIAS B.A</h1>
        </div>
        <div class="header-menu">
            <a href="index.html#carrusel">Las Conferencias</a>
            <a href="index.html#Oradores">Los Oradores</a>
            <a href="asistirEvento.html" class="text-warning">QUIERO ASISTIR!</a>
        </div>
    </div>
    <h1>Listado de oradores de nuestra base de datos</h1>

    <!-- Programación en PHP -->
    <?php
    // Variables de la conexión a la DB
    $mysqli = new mysqli("localhost", "root", "", "programacion web");

    // Verificamos la conexión
    if ($mysqli->connect_error) {
      die("Error de conexión: " . $mysqli->connect_error);
      }

    // Ejecutamos consulta SQL en MySQL
    $query = $mysqli->query("SELECT oradores.NombreOrador, oradores.ApellidoOrador, oradores.DescripcionOrador, oradores.RutaImagen, tematicas.DescripcionTematica
    FROM oradores
    JOIN tematicas ON oradores.IdTematica = tematicas.IdTematica;");

      // Verificamos si hubo algún error en la consulta
      if (!$query) {
      die("Error en la consulta: " . $mysqli->error);
      }

    // Verificamos si la consulta no está vacía y retorna un array asociativo
    $oradores = [];
if ($query && $query->num_rows > 0) {
    while ($resultado = $query->fetch_assoc()) {
        $oradores[] = $resultado;
    }
} else {
    // No hay resultados, puedes mostrar un mensaje o redirigir a otra página
    echo "No hay datos disponibles.";
    exit;
}
    ?>
    <ul>
        <?php
        $long = count($oradores);
        for ($i = 0; $i < $long; $i++) {
            ?>
            <li>
                <?php
                echo $oradores[$i]['NombreOrador'];
                echo "  ";
                echo $oradores[$i]['ApellidoOrador'];
                echo ", ";
                echo $oradores[$i]['DescripcionOrador'];
                echo ", tema a tratar: ";
                echo $oradores[$i]['DescripcionTematica'];
                echo '<img src="' . $oradores[$i]['RutaImagen'] . '" alt="Imagen de ' . $oradores[$i]['NombreOrador'] . '">';
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
<!-- Footer -->
<div id="footer" class="bg-dark text-white p-3 d-flex flex-column align-items-center justify-content-center">
    2023 - DERECHOS RESERVADOS @
    <img src="Imagenes/LOGO BA.png" alt="" class="w-25 mt-3">
</div>
</html>
