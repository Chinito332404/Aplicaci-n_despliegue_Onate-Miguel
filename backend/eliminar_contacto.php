<?php

require_once __DIR__ . '/funciones.php';

exigir_solicitud_post();
$usuario = exigir_usuario_activo('../index.php?mensaje=debe_iniciar_sesion');
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    redirigir('../contactos.php?mensaje=contacto_no_encontrado');
}

$conexion = obtener_conexion();
$consulta = $conexion->prepare('DELETE FROM contactos WHERE id = ? AND id_usuario = ?');
$consulta->execute([$id, (int) $usuario['id']]);

redirigir('../contactos.php?mensaje=contacto_eliminado');
