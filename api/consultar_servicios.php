<?php
// api/consultar_servicios.php
// Limpiar salidas previas y configurar CORS y tipo de contenido
if (!headers_sent()) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Content-Type: application/json; charset=utf-8");
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include __DIR__ . '/database.php';

$sql = "SELECT prov.id_proveedor, prov.nombre, prov.ciudad, prov.direccion, prov.telefono, serv.id_servicio, serv.nombre_servicio, serv.descripcion, serv.categoria, serv.precio FROM proveedor AS prov INNER JOIN servicio AS serv ON prov.id_proveedor = serv.id_proveedor;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$servicio_proveedor = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $servicio_proveedor[] = $row;
}

echo json_encode($servicio_proveedor);
?>