<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema_web";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $clave = mysqli_real_escape_string($conn, $_POST['clave']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $carrera = mysqli_real_escape_string($conn, $_POST['carrera']);
    $especialidad = mysqli_real_escape_string($conn, $_POST['especialidad']);
    $cedula = mysqli_real_escape_string($conn, $_POST['cedula']);
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); 

    $sql_check = "SELECT * FROM docente WHERE clave = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $clave);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>
                alert('Ya existe un docente con esta clave.');
                window.location.href = '../Registro_Docente.php'; // Redirigir a la página de registro
              </script>";
        exit;
    }

    $sql_insert = "INSERT INTO docente (clave, nombre, carrera, especialidad, cedula, usuario, contrasena) 
               VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $clave, $nombre, $carrera, $especialidad, $cedula, $usuario, $contrasena);


    if ($stmt_insert->execute()) {
        echo "<script>
                alert('Registro exitoso');
                window.location.href = '../index.php'; // Redirigir a la página principal
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error al registrar el docente: " . $conn->error . "');
                window.location.href = '../Registro_Docente.php'; // Redirigir a la página de registro
              </script>";
    }

    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();
}
