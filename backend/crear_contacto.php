<?php

require_once __DIR__ . '/funciones.php';

exigir_solicitud_post();
$usuario = exigir_usuario_activo('../index.php?mensaje=debe_iniciar_sesion');

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');

if ($nombre === '' || $telefono === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL) || $ciudad === '') {
    redirigir('../contactos.php?mensaje=datos_contacto_invalidos');
}

$conexion = obtener_conexion();
$consulta = $conexion->prepare('INSERT INTO contactos (id_usuario, nombre, telefono, correo, ciudad) VALUES (?, ?, ?, ?, ?)');
// El id del usuario autenticado se guarda con el contacto; así no puede pertenecer a otro usuario.
$consulta->execute([(int) $usuario['id'], $nombre, $telefono, $correo, $ciudad]);

redirigir('../contactos.php?mensaje=contacto_creado');
