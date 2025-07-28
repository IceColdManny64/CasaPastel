<?php
require_once 'pwclass.php';
$db = new PWClass();
$conn = $db->obtenerConexion();

$id = intval($_POST['id'] ?? 0);
$correo = $_POST['correo'] ?? '';
$pass   = $_POST['pass']   ?? '';

$stmt = $conn->prepare("UPDATE usuarios SET correo=?, pass=? WHERE id=?");
$stmt->bind_param('ssi', $correo, $pass, $id);

if ($stmt->execute()) {
  $resp = ['ok'=>true, 'msg'=>'Usuario actualizado correctamente.'];
} else {
  $resp = ['ok'=>false,'msg'=>'Error al actualizar usuario.'];
}

header('Content-Type: application/json');
echo json_encode($resp);
