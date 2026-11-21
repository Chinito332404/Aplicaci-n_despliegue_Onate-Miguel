<?php

require_once __DIR__ . '/conexion.php';

function escapar_html(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function obtener_usuario_activo(): ?array
{
    if (!isset($_SESSION['id_usuario'])) {
        return null;
    }

    $conexion = obtener_conexion();
    $consulta = $conexion->prepare('SELECT id, nombre, correo FROM usuarios WHERE id = ?');
    $consulta->execute([(int) $_SESSION['id_usuario']]);
    $usuario = $consulta->fetch();

    return $usuario ?: null;
}

function exigir_usuario_activo(string $ruta_inicio = 'index.php?mensaje=debe_iniciar_sesion'): array
{
    $usuario = obtener_usuario_activo();

    if ($usuario === null) {
        redirigir($ruta_inicio);
    }

    return $usuario;
}

function exigir_solicitud_post(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirigir('../index.php');
    }
}
