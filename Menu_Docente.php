<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$clave_docente = $_SESSION['clave_docente'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $carrera = $_POST['carrera'];
    $especialidad = $_POST['especialidad'];
    $cedula = $_POST['cedula'];

    if (!empty($_FILES['foto']['name'])) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_folder = 'uploads/' . $foto_name;
        move_uploaded_file($foto_tmp_name, $foto_folder);
    } else {
        $foto_folder = $row['foto'];
    }

    $sql_update = "UPDATE docente SET nombre = ?, carrera = ?, especialidad = ?, cedula = ?, foto = ? WHERE clave = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssss", $nombre, $carrera, $especialidad, $cedula, $foto_folder, $clave_docente);

    if ($stmt->execute()) {
        echo "Datos actualizados exitosamente.";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

$sql = "SELECT * FROM docente WHERE clave = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Error al preparar la consulta: ' . $conn->error);
}
$stmt->bind_param("s", $clave_docente);
$stmt->execute();
$result = $stmt->get_result();

$row = [
    'clave' => '',
    'nombre' => '',
    'carrera' => '',
    'especialidad' => '',
    'cedula' => '',
    'foto' => 'Imagenes/Docente.png'
];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="Css/Menu_Docente.css">
    <link rel="icon" href="Imagenes/Sistema.png">
    <style>
        .submit {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
    <title>Sistema Docente</title>
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
            <form class="form" method="POST" enctype="multipart/form-data" action="">
                <label for="clave"><i class="fas fa-id-card"></i> Clave:</label>
                <input type="text" id="clave" name="clave" value="<?php echo $row['clave']; ?>" readonly>

                <label for="nombre"><i class="fas fa-user"></i> Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>

                <label for="carrera"><i class="fas fa-graduation-cap"></i> Carrera:</label>
                <input type="text" id="carrera" name="carrera" value="<?php echo $row['carrera']; ?>" required>

                <div class="form-control">
                    <label for="especialidad"><i class="fas fa-book"></i> Especialidad:</label>
                    <input type="text" id="especialidad" name="especialidad" value="<?php echo $row['especialidad']; ?>" required>
                </div>

                <label for="cedula"><i class="fas fa-id-card-alt"></i> Cédula:</label>
                <input type="text" id="cedula" name="cedula" value="<?php echo $row['cedula']; ?>" required>

                <label for="foto"><i class="fas fa-camera"></i> Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*">

                <input type="submit" name="guardar" value="Guardar" class="submit">
            </form>
        </div>

    </div>
    <script defer src="https://app.embed.im/snow.js"></script>

</body>
</html>
