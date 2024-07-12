<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="Css/Registro_Docente.css">
    <link rel="icon" href="Imagenes/Sistema.png">
    <title>Registro de Docentes</title>
</head>

<body>
    <div class="container">
        <form class="form" action="Php/Procesar_Registro_2.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <h1>Registro de Docentes</h1>

            <div class="form-control">
                <label for="clave"><i class="fas fa-id-card"></i> Clave:</label>
                <input type="text" id="clave" name="clave" required>
                <span id="claveError" class="error"></span>
            </div>

            <div class="form-control">
                <label for="nombre"><i class="fas fa-user"></i> Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <span id="nombreError" class="error"></span>
            </div>

            <div class="form-control">
                <label for="carrera"><i class="fas fa-graduation-cap"></i> Carrera:</label>
                <input type="text" id="carrera" name="carrera" required>
            </div>

            <div class="form-control">
                <label for="especialidad"><i class="fas fa-book"></i> Especialidad:</label>
                <input type="text" id="especialidad" name="especialidad" required>
            </div>

            <div class="form-control">
                <label for="cedula"><i class="fas fa-id-card-alt"></i> Cédula:</label>
                <input type="text" id="cedula" name="cedula" required>
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
                <span id="fotoError" class="error"></span>
            </div>

            <div class="button-container">
                <button type="submit">Registrarse</button>
            </div>
        </form>
    </div>

    <div id="warningModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('warningModal')">&times;</span>
            <h2><i class="fas fa-exclamation-triangle"></i> Advertencia</h2>
            <p id="warningMessage"></p>
        </div>
    </div>

    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('errorModal')">&times;</span>
            <h2><i class="fas fa-times-circle"></i> Error</h2>
            <p id="errorMessage"></p>
        </div>
    </div>

    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('successModal')">&times;</span>
            <h2><i class="fas fa-check-circle"></i> Éxito</h2>
            <p id="successMessage"></p>
        </div>
    </div>

    <script>
        function validateForm() {
            var clave = document.getElementById('clave').value;
            var nombre = document.getElementById('nombre').value;
            var foto = document.getElementById('foto').value;

            var claveRegex = /^[0-9]+$/;
            var nombreRegex = /^[a-zA-Z\s]+$/;
            var fotoRegex = /\.(jpg|jpeg|png|gif)$/i;

            var isValid = true;

            if (!clave.match(claveRegex)) {
                document.getElementById('claveError').textContent = "La clave debe contener solo números.";
                showModal('warningModal', 'Advertencia', 'La clave debe contener solo números.');
                isValid = false;
            } else {
                document.getElementById('claveError').textContent = "";
            }

            if (!nombre.match(nombreRegex)) {
                document.getElementById('nombreError').textContent = "El nombre debe contener solo letras y espacios.";
                showModal('warningModal', 'Advertencia', 'El nombre debe contener solo letras y espacios.');
                isValid = false;
            } else {
                document.getElementById('nombreError').textContent = "";
            }

            if (!foto.match(fotoRegex)) {
                document.getElementById('fotoError').textContent = "El formato de la foto no es válido. Debe ser JPG, JPEG, PNG o GIF.";
                showModal('warningModal', 'Advertencia', 'El formato de la foto no es válido. Debe ser JPG, JPEG, PNG o GIF.');
                isValid = false;
            } else {
                document.getElementById('fotoError').textContent = "";
            }

            return isValid;
        }

        function showModal(modalId, title, message) {
            document.getElementById(modalId).style.display = "block";
            document.getElementById(modalId).querySelector('h2').textContent = title;
            document.getElementById(modalId).querySelector('p').textContent = message;
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }
    </script>
    <script defer src="https://app.embed.im/snow.js"></script>

</body>

</html>