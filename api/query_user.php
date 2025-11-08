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