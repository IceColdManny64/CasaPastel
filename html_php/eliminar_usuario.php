<?php
require_once 'pwclass.php';
$db = new PWClass();
$conn = $db->obtenerConexion();

$id = intval($_POST['id'] ?? 0);
$stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
  $resp = ['ok'=>true, 'msg'=>'Usuario eliminado correctamente.'];
} else {
  $resp = ['ok'=>false,'msg'=>'Error al eliminar usuario.'];
}

header('Content-Type: application/json');
echo json_encode($resp);
