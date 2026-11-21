<?php

/* Configuracion sencilla: usa variables del sistema o backend/.env. */
function cargar_entorno(string $archivo): void
{
    if (!is_file($archivo)) {
        return;
    }

    foreach (file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
        $linea = trim($linea);
        if ($linea === '' || str_starts_with($linea, '#') || !str_contains($linea, '=')) {
            continue;
        }

        [$nombre, $valor] = explode('=', $linea, 2);
        $nombre = trim($nombre);
        $valor = trim($valor, " \t\n\r\0\x0B\"'");

        if ($nombre !== '' && getenv($nombre) === false) {
            putenv($nombre . '=' . $valor);
            $_ENV[$nombre] = $valor;
        }
    }
}

cargar_entorno(__DIR__ . '/.env');

const SERVIDOR_BD = '127.0.0.1';
const NOMBRE_BD = 'agenda_miguel';
const USUARIO_BD = 'root';
const CLAVE_BD = '';

function variable_entorno(string $nombre, string $predeterminado): string
{
    $valor = getenv($nombre);
    return $valor === false || $valor === '' ? $predeterminado : $valor;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function redirigir(string $ruta): void
{
    header('Location: ' . $ruta);
    exit;
}
