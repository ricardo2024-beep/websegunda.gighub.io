<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="Css/index.css">
    <link rel="icon" href="Imagenes/Sistema.png">
    <title>Bienvenido al Sistema</title>
    <style>
        .error-message {
            color: #dc3545;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form class="form" action="Php/Login.php" method="POST" onsubmit="return validateForm()">
        <h1>Inicio de Sesión</h1>

        <?php
        if (isset($_GET['error'])) {
            $error_code = $_GET['error'];
            if ($error_code == 1) {
                echo '<p class="error-message">Contraseña incorrecta.</p>';
            } elseif ($error_code == 2) {
                echo '<p class="error-message">Usuario no encontrado.</p>';
            } elseif ($error_code == 3) {
                echo '<p class="error-message">Por favor, llene todos los campos.</p>';
            }
        }
        ?>

        <div class="input-container">
            <i class="fas fa-user icon"></i>
            <label for="user">Ingrese el Usuario:</label>
            <input type="text" id="user" name="user_name" required>
        </div>

        <div class="input-container">
            <i class="fas fa-lock icon"></i>
            <label for="pass">Ingrese la Contraseña:</label>
            <input type="password" id="pass" name="password" required>
        </div>

        <button type="submit" name="action" value="login">Entrar</button>
        <button type="button" onclick="location.href='Tipo_Registro.php'">Registrarse</button>
    </form>

    <script>
        function validateForm() {
            var user = document.getElementById("user").value;
            var pass = document.getElementById("pass").value;
            if (user.trim() === '' || pass.trim() === '') {
                alert('Por favor, llene todos los campos.');
                return false;
            }
            return true;
        }
    </script>
        <script defer src="https://app.embed.im/snow.js"></script>

</body>
</html>
