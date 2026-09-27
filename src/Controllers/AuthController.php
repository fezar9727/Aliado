<?php
declare(strict_types=1);

namespace Aliado\Controllers;

use Aliado\Models\Usuario;

// AuthController.php
// Orquesta el registro y el inicio de sesion. Nunca ejecuta SQL
// directamente (eso es responsabilidad exclusiva del modelo Usuario)
// y nunca expone si un usuario existe o no en los mensajes de error
// de login, para no facilitar ataques de enumeracion de usuarios.
class AuthController
{
    public function registrar(string $nombreUsuario, string $correo, string $password): array
    {
        if (trim($nombreUsuario) === '' || trim($correo) === '' || trim($password) === '') {
            return ['exito' => false, 'mensaje' => 'Todos los campos son obligatorios.'];
        }

        if (Usuario::existePorNombreUsuario($nombreUsuario)) {
            return ['exito' => false, 'mensaje' => 'Ese nombre de usuario ya esta registrado.'];
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $creado = Usuario::crear($nombreUsuario, $correo, $passwordHash);

        if (!$creado) {
            return ['exito' => false, 'mensaje' => 'No se pudo completar el registro.'];
        }

        return ['exito' => true, 'mensaje' => 'Usuario registrado correctamente.'];
    }

    public function iniciarSesion(string $nombreUsuario, string $password): array
    {
        $usuario = Usuario::buscarPorNombreUsuario($nombreUsuario);

        // Mensaje generico e identico tanto si el usuario no existe como
        // si la contrasena es incorrecta: evita revelar cuales usuarios
        // existen en el sistema.
        if ($usuario === false || !password_verify($password, $usuario['password_hash'])) {
            return ['exito' => false, 'mensaje' => 'Usuario o contrasena incorrectos.'];
        }

        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];

        return ['exito' => true, 'mensaje' => 'Autenticacion satisfactoria.'];
    }
}
