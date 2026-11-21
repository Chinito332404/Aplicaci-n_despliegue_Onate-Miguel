<?php

require_once __DIR__ . '/funciones.php';

exigir_solicitud_post();

$correo = trim($_POST['correo'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';

$conexion = obtener_conexion();
$consulta = $conexion->prepare('SELECT id, contrasena FROM usuarios WHERE correo = ?');
$consulta->execute([$correo]);
$usuario = $consulta->fetch();

// password_verify() compara la contraseña ingresada con el hash guardado en la base de datos.
if (!$usuario || !password_verify($contrasena, $usuario['contrasena'])) {
    redirigir('../index.php?mensaje=credenciales_incorrectas');
}

session_regenerate_id(true);
$_SESSION['id_usuario'] = (int) $usuario['id'];

redirigir('../contactos.php');
