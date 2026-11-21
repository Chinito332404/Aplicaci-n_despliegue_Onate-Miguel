-- Script compatible con el panel de InfinityFree.
-- Importar dentro de la base de datos seleccionada.

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
    CONSTRAINT fk_contactos_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nombre, correo, contrasena)
VALUES ('Usuario de prueba', 'usuario@ejemplo.com', '$2y$10$Q6lNeu3/osfhqr0Y4T/0BeNkeya4tenvm/e3s.zNeZWibNasGLtm.')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);
