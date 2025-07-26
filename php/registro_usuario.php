<?php
require_once 'pwclass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"] ?? "";
    $edad = $_POST["edad"] ?? "";
    $correo = $_POST["correo"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmar = $_POST["confirmar"] ?? "";

    // Validar campos obligatorios
    if (empty($nombre) || empty($edad) || empty($correo) || empty($password) || empty($confirmar)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit;
    }

    if ($password !== $confirmar) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    $db = new PWClass();
    $conn = $db->obtenerConexion();

    // Verificar si el correo ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<script>alert('Este correo ya está registrado.'); window.history.back();</script>";
        exit;
    }
    $stmt->close();

    // Insertar usuario nuevo
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, edad, correo, pass) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $nombre, $edad, $correo, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href='loginUsuario.html';</script>";
    } else {
        echo "<script>alert('Error al registrar.'); window.history.back();</script>";
    }

    $stmt->close();
    $db->cerrar();
} else {
    echo "<script>alert('Acceso no permitido.'); window.location.href='registroUsuario.html';</script>";
}
?>
