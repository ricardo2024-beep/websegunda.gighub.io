<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema_web";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $password_input = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($user_name) || empty($password_input)) {
        header("Location: ../index.php?error=3");
        exit();
    }

    $sql_estudiante = "SELECT * FROM estudiante WHERE usuario = ?";
    $stmt = $conn->prepare($sql_estudiante);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result_estudiante = $stmt->get_result();

    if ($result_estudiante->num_rows > 0) {
        $row = $result_estudiante->fetch_assoc();
        if (password_verify($password_input, $row['contrasena'])) {
            $_SESSION['user_name'] = $row['usuario'];
            header("Location: ../Menu_Estudiante.php");
            exit();
        } else {
            header("Location: ../index.php?error=1");
            exit();
        }
    }

    $sql_docente = "SELECT * FROM docente WHERE Usuario = ?";
    $stmt = $conn->prepare($sql_docente);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result_docente = $stmt->get_result();

    if ($result_docente->num_rows > 0) {
        $row = $result_docente->fetch_assoc();
        if (password_verify($password_input, $row['Contrasena'])) {
            $_SESSION['user_name'] = $row['Usuario'];
            $_SESSION['clave_docente'] = $row['clave']; 
            header("Location: ../Menu_Docente.php");
            exit();
        } else {
            header("Location: ../index.php?error=1");
            exit();
        }
    }

    header("Location: ../index.php?error=2");
    exit();

    $conn->close();
}
?>
