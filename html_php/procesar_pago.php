<?php
require_once 'pwclass.php';
$db = new PWClass();
$conn = $db->obtenerConexion();

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !is_array($data)) {
    http_response_code(400);
    echo "Datos no válidos.";
    exit;
}

$error = false;
foreach ($data as $item) {
    $id = intval($item['id']);
    $cantidad = intval($item['cantidad']);

    $stmt = $conn->prepare("SELECT stock FROM postresitos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) continue;

    $stockActual = $res->fetch_assoc()['stock'];

    if ($stockActual >= $cantidad) {
        $nuevoStock = $stockActual - $cantidad;
        $update = $conn->prepare("UPDATE postresitos SET stock = ? WHERE id = ?");
        $update->bind_param("ii", $nuevoStock, $id);
        $update->execute();
        $update->close();
    } else {
        $error = true;
    }

    $stmt->close();
}

$db->cerrar();

if ($error) {
    echo "Pago realizado parcialmente. Algunos productos no tenían suficiente stock.";
} else {
    echo "¡Pago exitoso! Gracias por tu compra.";
}
