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

$input = json_decode(file_get_contents("php://input"), true);
$correo = $input['correo'];
$contrasena = $input['contrasena'];

//echo json_encode(["correo" => $correo, "contrasena" => $contrasena]);
// Primero buscamos en proveedores
$stmt = $pdo->prepare("SELECT * FROM proveedor WHERE correo = ?;");
$stmt->execute([$correo]);
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

if ($proveedor && password_verify($contrasena, $proveedor['contrasena'])) {
    echo json_encode(["status" => "ok", "tipo" => "proveedor", "id" => $proveedor['id_proveedor'], "nombre" => $proveedor['nombre']]);
    exit;
}

// Si no existe en proveedores, buscamos en clientes
$stmt = $pdo->prepare("SELECT * FROM cliente WHERE correo = ?");
$stmt->execute([$correo]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cliente && password_verify($contrasena, $cliente['contrasena'])) {
    echo json_encode(["status" => "ok", "tipo" => "cliente", "id" => $cliente['id']]);
    exit;
}

// No encontrado
echo json_encode(["status" => "error", "mensaje" => "Usuario no encontrado o contraseña incorrecta"]);
?>