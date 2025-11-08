<?php
include ("./database.php");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents("php://input"), true);
$cat = $input['categoria'];

$sql = "SELECT prov.id_proveedor, prov.nombre, prov.ciudad, prov.direccion, prov.telefono, serv.id_servicio, serv.nombre_servicio, serv.descripcion, serv.categoria, serv.precio FROM proveedor AS prov INNER JOIN servicio AS serv ON prov.id_proveedor = serv.id_proveedor AND serv.categoria = ?;";
$stmt = $pdo->prepare($sql);
$stmt->execute([$cat]);
$servicio_proveedor = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $servicio_proveedor[] = $row;
}

echo json_encode($servicio_proveedor);
