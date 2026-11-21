<?php

require_once __DIR__ . '/backend/funciones.php';

if (obtener_usuario_activo()) {
    redirigir('contactos.php');
}

$mensajes = [
    'datos_invalidos' => 'Complete los datos correctamente. La contraseña debe tener al menos 6 caracteres.',
    'correo_existente' => 'El correo ya está registrado.',
];
$mensaje = $mensajes[$_GET['mensaje'] ?? ''] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="estilos1.css">
</head>
<body>
    <main class="principal">
        <section class="tarjeta-registro">
            <h1 class="titulo">Registro de usuario</h1>
            <?php if ($mensaje !== ''): ?>
                <p><?= escapar_html($mensaje) ?></p>
            <?php endif; ?>
            <form class="formulario" action="backend/registrar_usuario.php" method="POST">
                <label class="label" for="nombre">Nombres completos</label>
                <input class="input" type="text" id="nombre" name="nombre" maxlength="70" required>
                <label class="label" for="correo">Correo electrónico</label>
                <input class="input" type="email" id="correo" name="correo" maxlength="150" required>
                <label class="label" for="contrasena">Contraseña</label>
                <input class="input" type="password" id="contrasena" name="contrasena" minlength="6" maxlength="100" required>
                <button class="boton" type="submit">Registrarse</button>
            </form>
            <p class="subtitulo"><a href="index.php">Volver al inicio de sesión</a></p>
        </section>
    </main>
</body>
</html>
