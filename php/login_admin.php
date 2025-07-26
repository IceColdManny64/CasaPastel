<?php
session_start();
require_once 'pwclass.php';

$pw = new PWClass();
$conn = $pw->obtenerConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $sqlAdmin = "SELECT * FROM admins WHERE usuario = ? AND passw = ?";
    $stmt = $conn->prepare($sqlAdmin);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['rol'] = 'admin';
        $_SESSION['usuario'] = $usuario;
        header("Location: adminDashboard.html");
        exit;
    }

    echo "<script>alert('Usuario o contraseña incorrectos'); window.history.back();</script>";
}
?>
