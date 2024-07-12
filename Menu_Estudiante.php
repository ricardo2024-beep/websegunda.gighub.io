<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$user_name = $_SESSION['user_name'];

$sql = "SELECT * FROM estudiante WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("No se encontró ningún estudiante con el nombre de usuario proporcionado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $carrera = $_POST['carrera'];
    $grupo = $_POST['grupo'];
    $turno = $_POST['turno'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if (!empty($contrasena)) {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql_update = "UPDATE estudiante SET matricula=?, nombre=?, edad=?, carrera=?, grupo=?, turno=?, contrasena=? WHERE usuario=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssisssss", $matricula, $nombre, $edad, $carrera, $grupo, $turno, $contrasena_hash, $usuario);
    } else {
        $sql_update = "UPDATE estudiante SET matricula=?, nombre=?, edad=?, carrera=?, grupo=?, turno=? WHERE usuario=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssissss", $matricula, $nombre, $edad, $carrera, $grupo, $turno, $usuario);
    }

    if ($stmt_update->execute()) {
        if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $ruta_destino = 'Imagenes/' . basename($_FILES['foto']['name']);
            move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino);
            $sql_update_foto = "UPDATE estudiante SET foto=? WHERE usuario=?";
            $stmt_update_foto = $conn->prepare($sql_update_foto);
            $stmt_update_foto->bind_param("ss", $ruta_destino, $usuario);
            $stmt_update_foto->execute();
        }

        echo '<script>
                alert("Perfil actualizado correctamente.");
                window.location.href = "perfil_estudiante.php";
              </script>';
    } else {
        echo "Error al actualizar el perfil: " . $stmt_update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="Css/Menu_Estudiante.css">
    <link rel="icon" href="Imagenes/Sistema.png">
    <title>Sistema Estudiante</title>

    <style>
        .mensaje-emergente {
            display: none;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="exit-btn" onclick="window.location.href='index.php'"><i class="fas fa-times"></i></button>

        <div class="sidebar">
            <div class="sidebar-content">
                <div class="profile-pic">
                    <img src="<?php echo $row['foto']; ?>" alt="Foto de perfil">
                </div>
            </div>
        </div>

        <div class="content">
            <form class="form" id="formulario" method="POST" enctype="multipart/form-data">
                <label for="matricula"><i class="fas fa-id-card"></i> Matrícula:</label>
                <input type="text" id="matricula" name="matricula" value="<?php echo $row['matricula']; ?>" required>

                <label for="nombre"><i class="fas fa-user"></i> Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>

                <label for="edad"><i class="fas fa-calendar"></i> Edad:</label>
                <input type="number" id="edad" name="edad" value="<?php echo $row['edad']; ?>" required>

                <label for="carrera"><i class="fas fa-user-graduate"></i> Carrera:</label>
                <input type="text" id="carrera" name="carrera" value="<?php echo $row['carrera']; ?>" required>

                <label for="grupo"><i class="fas fa-users"></i> Grupo:</label>
                <input type="text" id="grupo" name="grupo" value="<?php echo $row['grupo']; ?>" required>

                <label for="turno"><i class="fas fa-clock"></i> Turno:</label>
                <input type="text" id="turno" name="turno" value="<?php echo $row['turno']; ?>" required>

                <label for="usuario"><i class="fas fa-user-shield"></i> Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo $row['usuario']; ?>" readonly>

                <label for="contrasena"><i class="fas fa-key"></i> Nueva contraseña:</label>
                <input type="password" id="contrasena" name="contrasena">

                <label for="foto"><i class="fas fa-image"></i> Foto de perfil:</label>
                <input type="file" id="foto" name="foto" accept="image/*">

                <button type="submit" name="guardar" id="guardar"><i class="fas fa-save"></i> Guardar cambios</button>
            </form>

            <div id="mensaje-emergente" class="mensaje-emergente">
                Perfil actualizado correctamente.
            </div>
        </div>
    </div>

    <script>
        document.getElementById("formulario").addEventListener("submit", function(event) {
            var form = document.getElementById("formulario");
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "perfil_estudiante.php", true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    document.getElementById("mensaje-emergente").style.display = "block";
                    setTimeout(function() {
                        document.getElementById("mensaje-emergente").style.display = "none";
                    }, 3000);
                }
            };
            xhr.send(formData);
            event.preventDefault();
        });
    </script>
    <script defer src="https://app.embed.im/snow.js"></script>
</body>
</html>
