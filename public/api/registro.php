<?php
declare(strict_types=1);

require_once __DIR__ . '/../../src/Core/Database.php';
require_once __DIR__ . '/../../src/Models/Usuario.php';
require_once __DIR__ . '/../../src/Controllers/AuthController.php';

use Aliado\Controllers\AuthController;

// api/registro.php
// Endpoint REST de registro. Recibe el cuerpo de la peticion en JSON
// y responde en JSON, reutilizando la misma logica de AuthController
// ya construida en AA5-EV01 (sin duplicar validaciones ni consultas).

header('Content-Type: application/json');

$cuerpo = json_decode(file_get_contents('php://input'), true) ?? [];

$controlador = new AuthController();
$resultado = $controlador->registrar(
    $cuerpo['nombre_usuario'] ?? '',
    $cuerpo['correo'] ?? '',
    $cuerpo['password'] ?? ''
);

http_response_code($resultado['exito'] ? 201 : 400);
echo json_encode($resultado);