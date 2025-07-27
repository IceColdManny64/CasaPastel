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

$stmt = $conn->prepare("SELECT * FROM postresitos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows === 0){
  http_response_code(404);
  echo json_encode(['error' => 'Postre no encontrado']);
  exit;
}

$postre = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($postre);

$stmt->close();
$db->cerrar();
?>
