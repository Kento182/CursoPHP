<?php
// Carpeta base segura
$base = realpath('.');

// Carpeta actual a mostrar
$path = isset($_GET['path']) ? $_GET['path'] : '.';
$realPath = realpath($path);

// Seguridad: que no se pueda salir del directorio raíz
if (!$realPath || strpos($realPath, $base) !== 0) {
    die("Acceso no permitido");
}

// Listar contenido
$archivos = scandir($realPath);

echo "<h2>Explorando: " . htmlspecialchars($realPath) . "</h2>";
echo "<ul>";

// Enlace para subir
if ($realPath !== $base) {
    $parent = dirname($path);
    echo "<li><a href='?path=" . urlencode($parent) . "'>⬆️ Subir</a></li>";
}

foreach ($archivos as $archivo) {
    if ($archivo === '.') continue;

    $rutaCompleta = $realPath . DIRECTORY_SEPARATOR . $archivo;
    $rutaRelativa = rtrim($path, '/') . '/' . $archivo;
    $rutaRelativaUrl = urlencode($rutaRelativa);

    if (is_dir($rutaCompleta)) {
        echo "<li>📁 <a href='?path=$rutaRelativaUrl'>" . htmlspecialchars($archivo) . "</a></li>";
    } else {
        echo "<li>📄 <a href='$rutaRelativa'>" . htmlspecialchars($archivo) . "</a></li>";
    }
}

echo "</ul>";