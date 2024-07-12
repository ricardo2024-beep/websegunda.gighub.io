<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="Css/Registro_Estudiante.css">
    <link rel="icon" href="Imagenes/Sistema.png">
    <title>Registro de Estudiante</title>
</head>

<body>
    <form class="form" action="Php/Procesar_Registros.php" method="POST" enctype="multipart/form-data" onsubmit="return enviarFormulario()">
        <h1>Registro de Estudiante</h1>

        <div class="form-control">
            <label for="matricula"><i class="fas fa-id-card"></i> Matrícula:</label>
            <input type="text" id="matricula" name="matricula" required>
        </div>

        <div class="form-control">
            <label for="nombre"><i class="fas fa-user"></i> Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-control">
            <label for="edad"><i class="fas fa-calendar-alt"></i> Edad:</label>
            <input type="number" id="edad" name="edad" required>
        </div>

        <div class="form-control">
            <label for="carrera"><i class="fas fa-graduation-cap"></i> Carrera:</label>
            <input type="text" id="carrera" name="carrera" required>
        </div>

        <div class="form-control">
            <label for="grupo"><i class="fas fa-users"></i> Grupo:</label>
            <input type="text" id="grupo" name="grupo" required>
        </div>

        <div class="form-control">
            <label for="turno"><i class="far fa-clock"></i> Turno:</label>
            <input type="text" id="turno" name="turno" required>
        </div>

        <div class="form-control">
            <label for="usuario"><i class="fas fa-user-lock"></i> Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>

        <div class="form-control">
            <label for="contrasena"><i class="fas fa-key"></i> Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
        </div>

        <div class="form-control">
            <label for="foto"><i class="fas fa-camera"></i> Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>
        </div>

        <button type="submit">Registrarse</button>
    </form>

    <script>
        function enviarFormulario() {
            var matricula = document.getElementById('matricula').value.trim();
            var nombre = document.getElementById('nombre').value.trim();
            var edad = document.getElementById('edad').value.trim();
            var carrera = document.getElementById('carrera').value.trim();
            var grupo = document.getElementById('grupo').value.trim();
            var turno = document.getElementById('turno').value.trim();
            var usuario = document.getElementById('usuario').value.trim();
            var contrasena = document.getElementById('contrasena').value.trim();
            var foto = document.getElementById('foto').value.trim();

            if (matricula === '' || nombre === '' || edad === '' || carrera === '' || grupo === '' || turno === '' || usuario === '' || contrasena === '' || foto === '') {
                alert('Todos los campos son obligatorios.');
                return false; 
            }

            if (isNaN(edad) || parseInt(edad) <= 0) {
                alert('Por favor, ingrese una edad válida.');
                return false; 
            }

            return true;
        }
    </script>

    <script defer src="https://app.embed.im/snow.js"></script>

</body>

</html>