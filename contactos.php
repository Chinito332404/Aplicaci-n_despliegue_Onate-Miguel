<?php

require_once __DIR__ . '/backend/funciones.php';

$usuario = exigir_usuario_activo();
$conexion = obtener_conexion();
// La condición id_usuario limita el listado a los contactos del usuario que inició sesión.
$busqueda = trim($_GET['busqueda'] ?? '');

// Solo se usan fragmentos SQL definidos aquÃ­; no se acepta ORDER BY libre.
$ordenesPermitidos = [
    'recientes' => 'id DESC',
    'nombre_asc' => 'nombre ASC',
    'nombre_desc' => 'nombre DESC',
    'ciudad_asc' => 'ciudad ASC',
    'ciudad_desc' => 'ciudad DESC',
];
$ordenSeleccionado = $_GET['orden'] ?? 'recientes';
$ordenSql = $ordenesPermitidos[$ordenSeleccionado] ?? $ordenesPermitidos['recientes'];

$sql = 'SELECT id, nombre, telefono, correo, ciudad FROM contactos WHERE id_usuario = :id_usuario';
$parametros = [':id_usuario' => (int) $usuario['id']];

if ($busqueda !== '') {
    $sql .= ' AND (nombre LIKE :busqueda OR correo LIKE :busqueda OR ciudad LIKE :busqueda)';
    $parametros[':busqueda'] = '%' . $busqueda . '%';
}

$sql .= ' ORDER BY ' . $ordenSql;
$consulta = $conexion->prepare($sql);
$consulta->execute($parametros);
$contactos = $consulta->fetchAll();

$mensajes = [
    'contacto_creado' => 'Contacto guardado correctamente.',
    'contacto_actualizado' => 'Contacto actualizado correctamente.',
    'contacto_eliminado' => 'Contacto eliminado correctamente.',
    'datos_contacto_invalidos' => 'Complete todos los datos del contacto correctamente.',
    'contacto_no_encontrado' => 'El contacto no existe o no le pertenece.',
];
$mensaje = $mensajes[$_GET['mensaje'] ?? ''] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis contactos</title>
    <link rel="stylesheet" href="estilos1.css">
</head>
<body>
    <main class="principal">
        <section class="tarjeta-registro">
            <h1 class="titulo">Mis contactos</h1>
            <p class="subtitulo">Usuario: <?= escapar_html($usuario['nombre']) ?> | <a href="backend/cerrar_sesion.php">Cerrar sesión</a></p>
            <?php if ($mensaje !== ''): ?>
                <p><?= escapar_html($mensaje) ?></p>
            <?php endif; ?>
            <form class="formulario" action="backend/crear_contacto.php" method="POST">
                <label class="label" for="nombre">Nombre del contacto</label>
                <input class="input" type="text" id="nombre" name="nombre" maxlength="70" required>
                <label class="label" for="telefono">Teléfono</label>
                <input class="input" type="text" id="telefono" name="telefono" maxlength="20" required>
                <label class="label" for="correo">Correo electrónico</label>
                <input class="input" type="email" id="correo" name="correo" maxlength="150" required>
                <label class="label" for="ciudad">Ciudad</label>
                <input class="input" type="text" id="ciudad" name="ciudad" maxlength="70" required>
                <button class="boton" type="submit">Guardar contacto</button>
            </form>

            <h2 class="subtitulo">Contactos registrados</h2>
            <form class="filtro-contactos" method="GET" action="contactos.php">
                <label class="label" for="busqueda">Buscar por nombre, correo o ciudad</label>
                <input class="input" type="search" id="busqueda" name="busqueda" maxlength="150" value="<?= escapar_html($busqueda) ?>" placeholder="Escriba un dato del contacto">
                <label class="label" for="orden">Ordenar contactos</label>
                <select class="input" id="orden" name="orden">
                    <option value="recientes" <?= $ordenSeleccionado === 'recientes' ? 'selected' : '' ?>>MÃ¡s recientes</option>
                    <option value="nombre_asc" <?= $ordenSeleccionado === 'nombre_asc' ? 'selected' : '' ?>>Nombre: A a Z</option>
                    <option value="nombre_desc" <?= $ordenSeleccionado === 'nombre_desc' ? 'selected' : '' ?>>Nombre: Z a A</option>
                    <option value="ciudad_asc" <?= $ordenSeleccionado === 'ciudad_asc' ? 'selected' : '' ?>>Ciudad: A a Z</option>
                    <option value="ciudad_desc" <?= $ordenSeleccionado === 'ciudad_desc' ? 'selected' : '' ?>>Ciudad: Z a A</option>
                </select>
                <button class="boton" type="submit">Aplicar</button>
                <?php if ($busqueda !== '' || $ordenSeleccionado !== 'recientes'): ?>
                    <a class="enlace-secundario" href="contactos.php">Limpiar filtro</a>
                <?php endif; ?>
            </form>
            <?php if (!$contactos): ?>
                <p>No se encontraron contactos con ese criterio.</p>
            <?php else: ?>
                <?php foreach ($contactos as $contacto): ?>
                    <p><strong><?= escapar_html($contacto['nombre']) ?></strong><br>
                        Teléfono: <?= escapar_html($contacto['telefono']) ?><br>
                        Correo: <?= escapar_html($contacto['correo']) ?><br>
                        Ciudad: <?= escapar_html($contacto['ciudad']) ?></p>
                    <div>
                        <a href="editar_contacto.php?id=<?= (int) $contacto['id'] ?>">Editar</a>
                        <form action="backend/eliminar_contacto.php" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar este contacto?');">
                            <input type="hidden" name="id" value="<?= (int) $contacto['id'] ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
