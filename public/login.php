<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Models/Usuario.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';

use Aliado\Controllers\AuthController;

$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new AuthController();
    $resultado = $controlador->iniciarSesion(
        $_POST['nombre_usuario'] ?? '',
        $_POST['password'] ?? ''
    );
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aliado - Iniciar sesion</title>
</head>
<body>
    <h1>Iniciar sesion</h1>

    <?php if ($resultado !== null): ?>
        <p><?= htmlspecialchars($resultado['mensaje']) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nombre de usuario
            <input type="text" name="nombre_usuario" required>
        </label>
        <label>Contrasena
            <input type="password" name="password" required>
        </label>
        <button type="submit">Ingresar</button>
    </form>

    <p><a href="registro.php">No tengo cuenta, registrarme</a></p>
</body>
</html>
