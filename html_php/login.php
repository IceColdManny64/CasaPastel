<?php
session_start();
require_once 'pwclass.php';

$pw = new PWClass();
$conn = $pw->obtenerConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sqlUser = "SELECT * FROM usuarios WHERE correo = ? AND pass = ?";
    $stmt = $conn->prepare($sqlUser);
    $stmt->bind_param("ss", $correo, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['rol'] = 'cliente';
        $_SESSION['usuario'] = $correo;
        header("Location: PantallaPrincipal.html");
        exit;
    }

    echo "<script>alert('Correo o contraseña incorrectos'); window.history.back();</script>";
}
?>
