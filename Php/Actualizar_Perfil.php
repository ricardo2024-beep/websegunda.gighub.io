<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_name'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema_web";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $matricula = mysqli_real_escape_string($conn, $_POST['matricula']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $edad = mysqli_real_escape_string($conn, $_POST['edad']);
    $carrera = mysqli_real_escape_string($conn, $_POST['carrera']);
    $grupo = mysqli_real_escape_string($conn, $_POST['grupo']);
    $turno = mysqli_real_escape_string($conn, $_POST['turno']);
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);

    $sql = "UPDATE estudiante SET matricula=?, nombre=?, edad=?, carrera=?, grupo=?, turno=?";

    $params = "ssisss";
    $values = array($matricula, $nombre, $edad, $carrera, $grupo, $turno);

    if (!empty($contrasena)) {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql .= ", contrasena=?";
        $params .= "s";
        $values[] = $contrasena_hash;
    }

    $sql .= " WHERE usuario=?";
    $params .= "s";
    $values[] = $usuario;

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param($params, ...$values);
        if ($stmt->execute()) {
            echo "Perfil actualizado correctamente.";
        } else {
            echo "Error al actualizar el perfil: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>
