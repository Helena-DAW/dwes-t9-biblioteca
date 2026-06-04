<?php
require_once 'Libros.php';
$librosObj = new Libros();
$conexion  = $librosObj->conexion('localhost', 'libros', 'root', '');
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Biblioteca</title>
</head>

<body>
  <h1>Autores y sus libros</h1>

  <?php
  if ($conexion === null) {
    echo '<p>Error al conectar con la base de datos.</p>';
  } else {
    $resAutores = $librosObj->consultarAutores($conexion);

    while ($autor = $resAutores->fetch_object()) {
      echo '<h2>' . htmlspecialchars($autor->nombre . ' ' . $autor->apellidos) . '</h2>';
      echo '<p>Nacionalidad: ' . htmlspecialchars($autor->nacionalidad) . '</p>';

      $resLibros = $librosObj->consultarLibros($conexion, (int)$autor->id);

      echo '<table border="1">';
      echo '<tr><th>ID</th><th>Título</th><th>Fecha publicación</th></tr>';

      while ($libro = $resLibros->fetch_object()) {
        echo '<tr>';
        echo '<td>' . $libro->id . '</td>';
        echo '<td>' . htmlspecialchars($libro->titulo) . '</td>';
        echo '<td>' . $libro->f_publicacion . '</td>';
        echo '</tr>';
      }

      echo '</table>';
      $resLibros->free();
    }
    $resAutores->free();
    mysqli_close($conexion);
  }

  ?>

</body>

</html>