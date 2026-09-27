<?php
declare(strict_types=1);

namespace Aliado\Models;

use Aliado\Core\Database;
use PDO;

// Usuario.php
// Modelo que centraliza el acceso a la tabla "usuarios". Es el unico
// lugar del proyecto que ejecuta SQL relacionado con usuarios, siempre
// mediante sentencias preparadas de PDO. La contrasena nunca se maneja
// en texto plano: se recibe ya hasheada por el controlador.
class Usuario
{
    public static function existePorNombreUsuario(string $nombreUsuario): bool
    {
        $pdo = Database::obtenerConexion();
        $consulta = $pdo->prepare('SELECT id FROM usuarios WHERE nombre_usuario = :nombreUsuario');
        $consulta->execute(['nombreUsuario' => $nombreUsuario]);

        return $consulta->fetch() !== false;
    }

    public static function crear(string $nombreUsuario, string $correo, string $passwordHash): bool
    {
        $pdo = Database::obtenerConexion();
        $consulta = $pdo->prepare(
            'INSERT INTO usuarios (nombre_usuario, correo, password_hash) VALUES (:nombreUsuario, :correo, :passwordHash)'
        );

        return $consulta->execute([
            'nombreUsuario' => $nombreUsuario,
            'correo' => $correo,
            'passwordHash' => $passwordHash,
        ]);
    }

    public static function buscarPorNombreUsuario(string $nombreUsuario): array|false
    {
        $pdo = Database::obtenerConexion();
        $consulta = $pdo->prepare('SELECT * FROM usuarios WHERE nombre_usuario = :nombreUsuario');
        $consulta->execute(['nombreUsuario' => $nombreUsuario]);

        return $consulta->fetch();
    }
}
