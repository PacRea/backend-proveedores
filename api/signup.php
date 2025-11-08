<?php
include ("./database.php");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

function edadLegal($fecha, $edadLegal = 18): bool
{
    $nacFecha = new DateTime($fecha);
    $hoyDia = new DateTime();

    $interval = $hoyDia->diff($nacFecha);
    $age = $interval->y;

    if ($age >= $edadLegal)
        return true;
    else
        return false;
}

include("../api/database.php");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents("php://input"), true);
if (edadLegal($input['fecha'])) {


    if ($input['tipo'] === "cliente") {
        try {
            $contrasena = password_hash($input['contrasena'], PASSWORD_BCRYPT);
            $insertQuery = "INSERT INTO cliente(nombre, fecha_nacimiento, correo, contrasena, telefono, ciudad, direccion) VALUES(?, ?, ?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($insertQuery);
            $stmt->execute([
                $input['nombre'],
                $input['fecha'],
                $input['correo'],
                $contrasena,
                $input['telefono'],
                $input['ciudad'],
                $input['direccion']
            ]);

            if ($stmt) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Cuenta creada como cliente" ,
                    "id" => $pdo->lastInsertId()
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "No se pudo crear la cuenta"
                ]);
            }
        } catch (PDOException $th) {
            echo json_encode([
                "status" => "error",
                "message" => "Error al registrar: " . $th->getMessage()
            ]);
        }
    } else if ($input['tipo'] === "proveedor") {
        try {
            $contrasena = password_hash($input['contrasena'], PASSWORD_BCRYPT);
            $insertQuery = "INSERT INTO proveedor(nombre, fecha, correo, contrasena, telefono, ciudad, direccion) VALUES(?, ?, ?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($insertQuery);
            $stmt->execute([
                $input['nombre'],
                $input['fecha'],
                $input['correo'],
                $contrasena,
                $input['telefono'],
                $input['ciudad'],
                $input['direccion']
            ]);

            if ($stmt) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Cuenta creada como proveedor",
                    "id" => $pdo->lastInsertId()
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "No se pudo crear la cuenta"
                ]);
            }
        } catch (PDOException $th) {
            echo json_encode([
                "status" => "error",
                "message" => "Error al registrar: " . $th->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "tipo" => "usuario"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "El usuario es menor de edad",
        "tipo" => "edad"
    ]);
}
