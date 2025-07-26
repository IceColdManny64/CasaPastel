<?php
require_once 'pwclass.php';

$db = new PWClass();
$conn = $db->obtenerConexion();

$query = "SELECT * FROM postresitos";
$result = $conn->query($query);

$postres = [];

while ($row = $result->fetch_assoc()) {
    $postres[] = $row;
}

header('Content-Type: application/json');
echo json_encode($postres);

$conn->close();
?>
