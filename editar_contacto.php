<?php

require_once __DIR__ . '/backend/funciones.php';

$usuario = exigir_usuario_activo();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    redirigir('contactos.php?mensaje=contacto_no_encontrado');
}

$conexion = obtener_conexion();
$consulta = $conexion->prepare('SELECT id, nombre, telefono, correo, ciudad FROM contactos WHERE id = ? AND id_usuario = ?');
$consulta->execute([$id, (int) $usuario['id']]);
$contacto = $consulta->fetch();

if (!$contacto) {
    redirigir('contactos.php?mensaje=contacto_no_encontrado');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar contacto</title>
    <link rel="stylesheet" href="estilos1.css">
</head>
<body>
    <main class="principal">
        <section class="tarjeta-registro">
            <h1 class="titulo">Editar contacto</h1>
            <form class="formulario" action="backend/editar_contacto.php" method="POST">
                <input type="hidden" name="id" value="<?= (int) $contacto['id'] ?>">
                <label class="label" for="nombre">Nombre del contacto</label>
                <input class="input" type="text" id="nombre" name="nombre" maxlength="70" value="<?= escapar_html($contacto['nombre']) ?>" required>
                <label class="label" for="telefono">Teléfono</label>
                <input class="input" type="text" id="telefono" name="telefono" maxlength="20" value="<?= escapar_html($contacto['telefono']) ?>" required>
                <label class="label" for="correo">Correo electrónico</label>
                <input class="input" type="email" id="correo" name="correo" maxlength="150" value="<?= escapar_html($contacto['correo']) ?>" required>
                <label class="label" for="ciudad">Ciudad</label>
                <input class="input" type="text" id="ciudad" name="ciudad" maxlength="70" value="<?= escapar_html($contacto['ciudad']) ?>" required>
                <button class="boton" type="submit">Guardar cambios</button>
            </form>
            <p class="subtitulo"><a href="contactos.php">Cancelar</a></p>
        </section>
    </main>
</body>
</html>
