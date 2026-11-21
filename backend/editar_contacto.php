<?php

require_once __DIR__ . '/funciones.php';

exigir_solicitud_post();
$usuario = exigir_usuario_activo('../index.php?mensaje=debe_iniciar_sesion');
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');

if (!$id || $nombre === '' || $telefono === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL) || $ciudad === '') {
    redirigir('../contactos.php?mensaje=datos_contacto_invalidos');
}

$conexion = obtener_conexion();
$consulta = $conexion->prepare('UPDATE contactos SET nombre = ?, telefono = ?, correo = ?, ciudad = ? WHERE id = ? AND id_usuario = ?');
$consulta->execute([$nombre, $telefono, $correo, $ciudad, $id, (int) $usuario['id']]);

redirigir('../contactos.php?mensaje=contacto_actualizado');
