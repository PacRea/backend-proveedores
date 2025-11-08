<?php
header("Content-Type: application/json");
echo json_encode([
  "status" => "ok",
  "mensaje" => "Bienvenido a la API de Agenda de Servicios Locales",
  "endpoints" => [
    "/api/proveedores.php"
    ]
  ]);
?>