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

    $matricula = mysqli_real_escape_string($conn, $_POST['matricula']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $edad = mysqli_real_escape_string($conn, $_POST['edad']);
    $carrera = mysqli_real_escape_string($conn, $_POST['carrera']);
    $grupo = mysqli_real_escape_string($conn, $_POST['grupo']);
    $turno = mysqli_real_escape_string($conn, $_POST['turno']);
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); 

    $foto = $_FILES['foto']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        $sql_check = "SELECT * FROM estudiante WHERE usuario = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $usuario);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "<script>
                    alert('El usuario ya está registrado. Intente con otro nombre de usuario.');
                    window.location.href = '../Registro_Estudiante.php'; // Redirigir a Registro_Estudiante.php
                  </script>";
            exit;
        } else {
            $sql_insert = "INSERT INTO estudiante (matricula, nombre, edad, carrera, grupo, turno, usuario, contrasena, foto)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssissssss", $matricula, $nombre, $edad, $carrera, $grupo, $turno, $usuario, $contrasena, $foto);

            if ($stmt_insert->execute()) {
                echo "<script>
                        alert('Registro exitoso');
                        window.location.href = '../index.php'; // Redirigir a index.php
                      </script>";
                exit;
            } else {
                echo "<script>
                        alert('Error al registrar al estudiante: " . $stmt_insert->error . "');
                        window.location.href = '../Registro_Estudiante.php'; // Redirigir a Registro_Estudiante.php
                      </script>";
            }

            $stmt_insert->close();
        }

        $stmt_check->close();
    } else {
        echo "<script>
                alert('Error al subir la foto.');
                window.location.href = '../Registro_Estudiante.php'; // Redirigir a Registro_Estudiante.php
              </script>";
    }

    $conn->close();
}
