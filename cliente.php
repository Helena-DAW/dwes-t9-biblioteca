<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>API DWES</title>
  <link rel="stylesheet" href="style.css">

  <!----- Validacion de formulario RA8_f con AJAX ----->
  <script>
    /**
     * Valida que el campo de búsqueda no esté vacío antes de enviar el formulario.
     *
     * @return {boolean} false si el campo está vacío (evita el envío), true si es válido.
     */
    function validarFormulario() {
      const texto = document.getElementById('texto').value.trim();
      if (texto === '') {
        alert('Por favor, introduce al menos un carácter para buscar.');
        return false;
      }
      buscarLibros(texto);
      return false; // Evita siempre el envío tradicional del formulario
    }

    /**
     * Realiza una petición AJAX a la API para buscar libros por título
     * y muestra los resultados en el div resultadoBusqueda.
     *
     * @param {string} texto - Texto a buscar en el título de los libros.
     * @return {void}
     */
    function buscarLibros(texto) {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'http://localhost/DWES_T8/api.php?action=buscar_libros&texto=' + encodeURIComponent(texto), true);

      xhr.onload = function() {
        if (xhr.status === 200) {
          const libros = JSON.parse(xhr.responseText);
          mostrarResultados(libros);
        }
      };

      xhr.send();
    }

    /**
     * Muestra los resultados de la búsqueda en el div resultadoBusqueda.
     * Si no hay resultados, muestra un mensaje informativo.
     *
     * @param {Array} libros - Lista de objetos libro devuelta por la API.
     * @return {void}
     */
    function mostrarResultados(libros) {
      const div = document.getElementById('resultadoBusqueda');

      if (libros.length === 0) {
        div.innerHTML = '<p>No se han encontrado libros.</p>';
        return;
      }

      let html = '<ul>';
      libros.forEach(function(libro) {
        html += '<li>';
        html += '<a href="http://localhost/DWES_T8/cliente.php?action=get_datos_libro&id=' + libro.id + '">';
        html += libro.titulo;
        html += '</a>';
        html += ' — ' + libro.nombre + ' ' + libro.apellidos;
        html += '</li>';
      });
      html += '</ul>';

      div.innerHTML = html;
    }
  </script>

</head>

<body>
  <div class="container">
    <h1 class="page-title">Biblioteca</h1>
    <?php
    // IF: Muestra los datos de un autor y su lista de libros
    if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_autor") {
      // Petición a la API para obtener los datos del autor con el id
      $app_info = file_get_contents('http://localhost/DWES_T8/api.php?action=get_datos_autor&id=' . $_GET["id"]);
      // Decodificamos el JSON recibido
      $app_info = json_decode($app_info);
    ?>
      <div class="detalle">
        <h3>Datos del autor</h3>
        <p><span>Nombre:</span> <?php echo $app_info->datos->nombre ?></p>
        <p><span>Apellidos:</span> <?php echo $app_info->datos->apellidos ?></p>
        <p><span>Nacionalidad:</span> <?php echo $app_info->datos->nacionalidad ?></p>
      </div>

      <div class="card">
        <h3>Libros</h3>
        <ul>
          <?php foreach ($app_info->libros as $libro): ?>
            <li>
              <a href="http://localhost/DWES_T8/cliente.php?action=get_datos_libro&id=<?php echo $libro->id ?>">
                <?php echo $libro->titulo; ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

    <?php
      // ELSE IF: Muestra los datos de un libro y enlace a su autor
    } elseif (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_libro") {
      // Peticion a la API para obtener los datos del libro con el id
      $app_info = file_get_contents('http://localhost/DWES_T8/api.php?action=get_datos_libro&id=' . $_GET["id"]);
      // Decodificamos el JSON
      $app_info = json_decode($app_info);
    ?>
      <div class="detalle">
        <h3>Datos del libro</h3>
        <p>Titulo: <?php echo $app_info->titulo ?></p>
        <p>Fecha de publicación: <?php echo $app_info->f_publicacion ?></p>
        <p>Autor:
          <a href="<?php echo "http://localhost/DWES_T8/cliente.php?action=get_datos_autor&id=" . $app_info->id_autor ?>">
            <?php echo $app_info->nombre . " " . $app_info->apellidos ?>
          </a>
        </p>
      </div>

      <div class="nav-links">
        <a href="http://localhost/DWES_T8/cliente.php">Volver al inicio</a>
      </div>

    <?php
      // ELSE: Muestra la lista de autores y la lista de libros
    } else {
      // Peticion a la API para obtener la lista de autores
      $lista_autores = file_get_contents('http://localhost/DWES_T8/api.php?action=get_listado_autores');
      // Petición a la API para obtener la lista de libros
      $lista_libros = file_get_contents('http://localhost/DWES_T8/api.php?action=get_listado_libros');
      // Decodificamos los JSON
      $lista_autores = json_decode($lista_autores);
      $lista_libros = json_decode($lista_libros);
    ?>
      <!----------- Formulario RA8_e --------->
      <div class="search-box">
        <h3>Buscar libros</h3>
        <form id="formBusqueda" onsubmit="return validarFormulario()">
          <input
            type="text"
            id="texto"
            name="texto"
            placeholder="Escribe el título o parte de él...">
          <button type="submit">Buscar</button>
        </form>
        <div id="resultadoBusqueda"></div>
      </div>
      <!-------------------------------------->
      <div class="cards">
        <div class="card">
          <h3>Autores</h3>
          <ul>
            <?php foreach ($lista_autores as $autor): ?>
              <li>
                <a href="<?php echo "http://localhost/DWES_T8/cliente.php?action=get_datos_autor&id=" . $autor->id ?>">
                  <?php echo $autor->nombre . " " . $autor->apellidos ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="card">
          <h3>Libros</h3>
          <ul>
            <?php foreach ($lista_libros as $libro): ?>
              <li>
                <a href="<?php echo "http://localhost/DWES_T8/cliente.php?action=get_datos_libro&id=" . $libro->id ?>">
                  <?php echo $libro->titulo ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php
    }
    ?>

  </div>
</body>

</html>