<?php

require_once __DIR__ . '/funciones.php';

exigir_solicitud_post();

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';

if ($nombre === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($contrasena) < 6) {
    redirigir('../pagina_de_registro.php?mensaje=datos_invalidos');
}

$conexion = obtener_conexion();
$consulta = $conexion->prepare('SELECT id FROM usuarios WHERE correo = ?');
$consulta->execute([$correo]);

if ($consulta->fetch()) {
    redirigir('../pagina_de_registro.php?mensaje=correo_existente');
}

$consulta = $conexion->prepare('INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)');
// password_hash() guarda un hash seguro y nunca la contraseña escrita por el usuario.
$consulta->execute([$nombre, $correo, password_hash($contrasena, PASSWORD_DEFAULT)]);

redirigir('../index.php?mensaje=registro_exitoso');
