<?php
declare(strict_types=1);

namespace Aliado\Core;

use PDO;
use PDOException;

// Database.php
// Envuelve la creacion de la conexion PDO hacia MySQL, leyendo la
// configuracion desde config/config.php. Centraliza en un solo lugar
// los parametros de conexion, para que ningun otro archivo del
// proyecto tenga que conocer usuario ni contrasena directamente.
class Database
{
    private static ?PDO $conexion = null;

    public static function obtenerConexion(): PDO
    {
        if (self::$conexion === null) {
            $config = require __DIR__ . '/../../config/config.php';

            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";

            try {
                self::$conexion = new PDO(
                    $dsn,
                    $config['db_user'],
                    $config['db_password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                // Nunca se expone el mensaje real de PDOException al usuario final,
                // porque puede contener detalles de la configuracion del servidor.
                throw new PDOException('No se pudo conectar a la base de datos.');
            }
        }

        return self::$conexion;
    }
}
