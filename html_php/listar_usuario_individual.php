<?php
require_once 'pwclass.php';

if(!isset($_GET['id'])){
  http_response_code(400);
  echo json_encode(['error' => 'ID no recibido']);
  exit;
}

$id = intval($_GET['id']);

$db = new PWClass();
$conn = $db->obtenerConexion();

$stmt = $conn->prepare("SELECT id, correo FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows === 0){
  http_response_code(404);
  echo json_encode(['error' => 'Usuario no encontrado']);
  exit;
}

$usuario = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($usuario);

$stmt->close();
$db->cerrar();
?>
