<?php
require_once 'pwclass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo   = trim($_POST["correo"] ?? "");
    $password = trim($_POST["password"] ?? "");

    // Validar campos obligatorios
    if (empty($correo) || empty($password)) {
        echo "<script>
                alert('Correo y contraseña son obligatorios.');
                window.history.back();
              </script>";
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Ingresa un correo electrónico válido.');
                window.history.back();
              </script>";
        exit;
    }

    $db   = new PWClass();
    $conn = $db->obtenerConexion();

    // Verificar si el correo ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<script>
                alert('Este correo ya está registrado.');
                window.history.back();
              </script>";
        exit;
    }
    $stmt->close();

    // Insertar usuario nuevo
    $stmt = $conn->prepare("INSERT INTO usuarios (correo, pass) VALUES (?, ?)");
    $stmt->bind_param("ss", $correo, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registro exitoso. Ahora puedes iniciar sesión.');
                window.location.href='loginUsuario.html';
              </script>";
    } else {
        echo "<script>
                alert('Error al registrar el usuario.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $db->cerrar();
    exit;
}
?>

