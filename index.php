<?php

require_once __DIR__ . '/backend/funciones.php';

if (obtener_usuario_activo()) {
    redirigir('contactos.php');
}

$mensajes = [
    'registro_exitoso' => 'Registro realizado. Ya puede iniciar sesión.',
    'sesion_cerrada' => 'Sesión cerrada correctamente.',
    'credenciales_incorrectas' => 'Correo o contraseña incorrectos.',
    'debe_iniciar_sesion' => 'Inicie sesión para continuar.',
];
$mensaje = $mensajes[$_GET['mensaje'] ?? ''] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda personal</title>
    <link rel="stylesheet" href="estilos1.css">
</head>
<body>
    <main class="principal">
        <section class="tarjeta-login">
            <h1 class="titulo">Agenda personal</h1>
            <p class="subtitulo">Inicie sesión para administrar sus contactos.</p>
            <?php if ($mensaje !== ''): ?>
                <p><?= escapar_html($mensaje) ?></p>
            <?php endif; ?>
            <form class="formulario" action="backend/iniciar_sesion.php" method="POST">
                <label class="label" for="correo">Correo electrónico</label>
                <input class="input" type="email" id="correo" name="correo" maxlength="150" required>
                <label class="label" for="contrasena">Contraseña</label>
                <input class="input" type="password" id="contrasena" name="contrasena" required>
                <button class="boton" type="submit">Iniciar sesión</button>
            </form>
            <p class="subtitulo"><a href="pagina_de_registro.php">¿No tiene una cuenta? Regístrese</a></p>
        </section>
    </main>
</body>
</html>
