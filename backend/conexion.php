<?php

require_once __DIR__ . '/configuracion.php';

function obtener_conexion(): PDO
{
    static $conexion = null;

    if ($conexion === null) {
        $servidor = variable_entorno('DB_HOST', SERVIDOR_BD);
        $puerto = variable_entorno('DB_PORT', '3306');
        $baseDatos = variable_entorno('DB_NAME', NOMBRE_BD);
        $usuario = variable_entorno('DB_USER', USUARIO_BD);
        $clave = variable_entorno('DB_PASSWORD', CLAVE_BD);

        $dsn = "mysql:host={$servidor};port={$puerto};dbname={$baseDatos};charset=utf8mb4";
        $conexion = new PDO($dsn, $usuario, $clave, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    return $conexion;
}
