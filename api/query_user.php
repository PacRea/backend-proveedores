<?php
include ("./database.php");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id'];

if($input['tipo'] === "cliente"){    
    $stmt = $pdo->prepare("SELECT * FROM cliente WHERE id = ?;");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($usuario);
}
else if($input['tipo'] === "proveedor"){
    $stmt = $pdo->prepare("SELECT * FROM proveedor WHERE id_proveedor = ?;");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($usuario);    
}
else{
    echo json_encode([
        "status" => "error",
        "mensaje" => "se requiere de un tipo de usuario"
    ]);
}
?>