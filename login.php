<?php
// Verificar si se ha enviado el formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST["email"];
    $contrasenia = $_POST["contraseña"];

    // Variables de la conexión a la DB
    $mysqli = new mysqli("localhost", "root", "", "programacion web");

    // Verificamos la conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Ejecutamos consulta SQL en MySQL
    $query = "SELECT * FROM Usuarios WHERE email = '$email' AND contrasenia = '$contrasenia'";
    $result = $mysqli->query($query);
    
    if ($result->num_rows > 0) {
        // Cambiamos el mensaje a una variable de sesión
        session_start();
        $_SESSION["mensaje"] = "¡Bienvenido! Ingresa tu email y contraseña.";
        // Redireccionamos al usuario
        header("Location: paginaAdmin.php");
        exit();
    } else {
        session_start();
        $_SESSION["mensaje"] = "Datos Incorrectos. Inténtalo de nuevo.";
        // Refrescamos la página
        header("Location: login.php");
        exit();
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();
}
?>

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
    <section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card login-container">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="Imagenes/LOGO BA.png" alt="Logo" class="w-50 mx-auto my-auto d-block">
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body">
                                <form method="post" action="login.php">
                                    <h5 class="fw-normal mb-3 pb-3">Ingresá tus datos</h5>
                                    <div class="form-outline mb-4">
                                        <input type="email" id="form2Example17" name="email" class="form-control form-control-lg" />
                                        <label class="form-label" for="form2Example17">Email</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="password" id="form2Example27" name="contraseña" class="form-control form-control-lg" />
                                        <label class="form-label" for="form2Example27">Contraseña</label>
                                    </div>
                                    <div class="pt-1 mb-4">
                                        <button id="boton-login" class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                    </div>
                                    <a href="oradores.php" class="small text-muted">Ver todos los oradores.</a>
                                    <a href="index.html" class="small text-muted">Página principal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- footer -->
    <div id="footer" class="bg-dark text-white p-3 d-flex justify-content-between">
        2023 - DERECHOS RESERVADOS @
        <img src="Imagenes/LOGO BA.png" alt="" class="w-25">
    </div>

    <script>
        // Verificar si hay un mensaje de sesión
        <?php
        session_start();
        if(isset($_SESSION["mensaje"])) {
            echo 'alert("' . $_SESSION["mensaje"] . '");';
            // Limpiar el mensaje de sesión
            unset($_SESSION["mensaje"]);
        }
        ?>
    </script>
</body>

</html>
