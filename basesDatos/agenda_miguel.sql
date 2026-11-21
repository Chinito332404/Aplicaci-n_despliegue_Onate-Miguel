CREATE DATABASE IF NOT EXISTS agenda_miguel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agenda_miguel;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(70) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contactos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    nombre VARCHAR(70) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    ciudad VARCHAR(70) NOT NULL,
    -- La relación impide asociar un contacto con un usuario inexistente.
    CONSTRAINT fk_contactos_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Usuario de demostración: correo usuario@ejemplo.com y contraseña 123456.
-- La contraseña está almacenada como hash generado con password_hash().
INSERT INTO usuarios (nombre, correo, contrasena)
VALUES ('Usuario de prueba', 'usuario@ejemplo.com', '$2y$10$Q6lNeu3/osfhqr0Y4T/0BeNkeya4tenvm/e3s.zNeZWibNasGLtm.')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);
