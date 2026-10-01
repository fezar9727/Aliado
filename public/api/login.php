<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../../src/Core/Database.php';
require_once __DIR__ . '/../../src/Models/Usuario.php';
require_once __DIR__ . '/../../src/Controllers/AuthController.php';

use Aliado\Controllers\AuthController;

// api/login.php
// Endpoint REST de inicio de sesion. Mismo patron que registro.php:
// recibe JSON, reutiliza AuthController, responde en JSON.

header('Content-Type: application/json');

$cuerpo = json_decode(file_get_contents('php://input'), true) ?? [];

$controlador = new AuthController();
$resultado = $controlador->iniciarSesion(
    $cuerpo['nombre_usuario'] ?? '',
    $cuerpo['password'] ?? ''
);

http_response_code($resultado['exito'] ? 200 : 401);
echo json_encode($resultado);