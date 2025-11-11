<?php
include("./database.php");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents("php://input"), true);
$urlSecure = $input['url'];
$id = $input['id'];
$query = "";
if (!isset($input['url'], $input['id'], $input['tipo'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Faltan datos requeridos"
    ]);
    exit;
}
try {
    if ($input['tipo'] === "cliente") {
        $query = "UPDATE cliente SET img_ruta = ? WHERE id = ?;";
    } else if ($input['tipo'] === "proveedor") {
        $query = "UPDATE proveedor SET img_ruta = ? WHERE id_proveedor = ?;";
    }
    $stmt = $pdo->prepare($query);
    $stmt->execute([$urlSecure, $id]);
    if ($stmt) {
        echo json_encode([
            "status" => "ok",
            "message" => "Imagen guardada con exito",
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No se pudo subir la imagen"
        ]);
    }
} catch (PDOException $th) {
    echo json_encode([
        "status" => "error",
        "message" => "Error" . $th->getMessage()
    ]);
}
