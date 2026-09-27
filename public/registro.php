<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Models/Usuario.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';

use Aliado\Controllers\AuthController;

$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new AuthController();
    $resultado = $controlador->registrar(
        $_POST['nombre_usuario'] ?? '',
        $_POST['correo'] ?? '',
        $_POST['password'] ?? ''
    );
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aliado - Registro</title>
</head>
<body>
    <h1>Registro de usuario</h1>

    <?php if ($resultado !== null): ?>
        <p><?= htmlspecialchars($resultado['mensaje']) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nombre de usuario
            <input type="text" name="nombre_usuario" required>
        </label>
        <label>Correo
            <input type="email" name="correo" required>
        </label>
        <label>Contrasena
            <input type="password" name="password" required>
        </label>
        <button type="submit">Registrarme</button>
    </form>

    <p><a href="login.php">Ya tengo cuenta, iniciar sesion</a></p>
</body>
</html>
