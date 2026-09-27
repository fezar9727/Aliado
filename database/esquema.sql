-- esquema.sql
-- Script de creacion de la tabla de usuarios para el servicio de
-- registro e inicio de sesion del proyecto Aliado.
-- La contrasena nunca se almacena en texto plano: password_hash
-- guarda el resultado de password_hash() de PHP (algoritmo bcrypt).

CREATE DATABASE IF NOT EXISTS aliado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE aliado;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    correo VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
