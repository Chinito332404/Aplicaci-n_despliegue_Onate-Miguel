<?php

require_once __DIR__ . '/configuracion.php';

$_SESSION = [];
session_destroy();

redirigir('../index.php?mensaje=sesion_cerrada');
