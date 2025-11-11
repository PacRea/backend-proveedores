<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require __DIR__ . '/../vendor/autoload.php';

use Cloudinary\Cloudinary;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configura tus credenciales de Cloudinary
    $cloudinary = new Cloudinary([
        'cloud' => [
            'cloud_name' => '//',
            'api_key'    => '//',
            'api_secret' => '//'
        ]
    ]);

    // Verifica si hay archivo
    if (isset($_FILES['imagen']['tmp_name'])) {
        try {
            $result = $cloudinary->uploadApi()->upload($_FILES['imagen']['tmp_name'], [
                'folder' => 'serviya', // opcional: carpeta en Cloudinary
            ]);

            // Devuelve la URL segura
            echo json_encode([
                "status" => "ok",
                "url" => $result['secure_url']
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "mensaje" => $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "mensaje" => "No se recibió ninguna imagen"
        ]);
    }
}
?>