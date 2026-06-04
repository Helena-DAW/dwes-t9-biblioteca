<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca · Cliente API</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #d0d7df;
      --card-bg: #ffffff;
      --text: #0f172a;
      --text-secondary: #475569;
      --accent: #4f46e5;
      --border: #e2e8f0;
      --shadow: 0 1px 3px rgba(0, 0, 0, .06), 0 8px 20px rgba(0, 0, 0, .06);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      padding: 60px 32px;
    }

    .container {
      width: 100%;
      max-width: 1100px;
      margin: 0 auto;
      background: var(--card-bg);
      border-radius: 24px;
      box-shadow: var(--shadow);
      padding: 60px 56px;
      border: 1px solid var(--border);
    }

    @media (max-width: 700px) {
      .container {
        padding: 36px 22px;
      }

      body {
        padding: 24px 12px;
      }
    }

    .header {
      margin-bottom: 40px;
      text-align: center;
    }

    .header h1 {
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .header .line {
      display: inline-block;
      width: 48px;
      height: 4px;
      background: var(--accent);
      border-radius: 2px;
      margin-bottom: 16px;
    }

    .header p {
      font-size: 15px;
      color: var(--text-secondary);
    }

    .badge {
      display: inline-block;
      background: #dcfce7;
      color: #166534;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      padding: 4px 12px;
      border-radius: 999px;
      margin-bottom: 12px;
    }

    /* Buscador */
    .search-box {
      background: #f8fafc;
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 24px;
      margin-bottom: 36px;
    }

    .search-box h3 {
      font-size: 16px;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 12px;
    }

    .search-box form {
      display: flex;
      gap: 10px;
    }

    .search-box input[type="text"] {
      flex: 1;
      padding: 12px 16px;
      border-radius: 8px;
      border: 1px solid var(--border);
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      outline: none;
      transition: border-color .2s;
    }

    .search-box input[type="text"]:focus {
      border-color: var(--accent);
    }

    .btn {
      padding: 12px 24px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 600;
      background: var(--accent);
      color: #fff;
      transition: background .2s;
      text-decoration: none;
    }

    .btn:hover {
      background: #4338ca;
    }

    .btn-back {
      background: #64748b;
    }

    .btn-back:hover {
      background: #475569;
    }

    /* Cards */
    .cards {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      margin-bottom: 36px;
    }

    @media (max-width: 650px) {
      .cards {
        grid-template-columns: 1fr;
      }
    }

    .card {
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 28px;
    }

    .card h3 {
      font-size: 18px;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 14px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--border);
    }

    .card ul {
      list-style: none;
      padding: 0;
    }

    .card li {
      padding: 10px 0;
      border-bottom: 1px solid #f1f5f9;
    }

    .card li:last-child {
      border-bottom: none;
    }

    .card a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
      font-size: 14px;
      transition: color .2s;
    }

    .card a:hover {
      color: #4338ca;
      text-decoration: underline;
    }

    /* Detalle */
    .detalle {
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 28px;
      margin-bottom: 24px;
    }

    .detalle h3 {
      font-size: 18px;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 16px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--border);
    }

    .detalle p {
      font-size: 15px;
      color: var(--text-secondary);
      margin: 10px 0;
    }

    .detalle p span {
      font-weight: 600;
      color: var(--text);
    }

    .detalle a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
    }

    .detalle a:hover {
      text-decoration: underline;
    }

    /* Resultados búsqueda */
    #resultadoBusqueda {
      margin-top: 16px;
    }

    #resultadoBusqueda ul {
      list-style: none;
      padding: 0;
      background: #ffffff;
      border-radius: 10px;
      border: 1px solid var(--border);
      padding: 12px 16px;
    }

    #resultadoBusqueda li {
      padding: 8px 0;
      border-bottom: 1px solid #f1f5f9;
      font-size: 14px;
    }

    #resultadoBusqueda li:last-child {
      border-bottom: none;
    }

    #resultadoBusqueda a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
    }

    #resultadoBusqueda a:hover {
      text-decoration: underline;
    }

    .nav-back {
      text-align: center;
      margin-top: 24px;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
      font-size: 18px;
      font-weight: bold;
      color: #1b2e49;
      line-height: 2;
    }

    /* Validación */
    .error-msg {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #991b1b;
      border-radius: 10px;
      padding: 16px 20px;
      text-align: center;
      font-weight: 500;
      margin-bottom: 24px;
    }
  </style>

  <script>
    function validarFormulario() {
      const texto = document.getElementById('texto').value.trim();
      if (texto === '') {
        alert('Por favor, introduce al menos un carácter para buscar.');
        return false;
      }
      buscarLibros(texto);
      return false;
    }

    function buscarLibros(texto) {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'api.php?action=buscar_libros&texto=' + encodeURIComponent(texto), true);

      xhr.onload = function() {
        if (xhr.status === 200) {
          const libros = JSON.parse(xhr.responseText);
          mostrarResultados(libros);
        }
      };

      xhr.send();
    }

    function mostrarResultados(libros) {
      const div = document.getElementById('resultadoBusqueda');

      if (libros.length === 0) {
        div.innerHTML = '<p style="color:#64748b;font-style:italic;text-align:center;">No se han encontrado libros.</p>';
        return;
      }

      let html = '<ul>';
      libros.forEach(function(libro) {
        html += '<li>';
        html += '<a href="cliente.php?action=get_datos_libro&id=' + libro.id + '">';
        html += libro.titulo;
        html += '</a>';
        html += ' &mdash; ' + libro.nombre + ' ' + libro.apellidos;
        html += '</li>';
      });
      html += '</ul>';

      div.innerHTML = html;
    }
  </script>
</head>

<body>

  <div class="container">

    <div class="header">
      <span class="badge">Aplicación</span>
      <h1>Biblioteca</h1>
      <span class="line"></span>
      <p>Consulta de autores y libros mediante API REST propia</p>
    </div>

    <?php
    if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_autor") {
      $app_info = file_get_contents('http://localhost/DWES_T9/api.php?action=get_datos_autor&id=' . $_GET["id"]);
      $app_info = json_decode($app_info);
    ?>
      <div class="detalle">
        <h3>Datos del autor</h3>
        <p><span>Nombre:</span> <?php echo htmlspecialchars($app_info->datos->nombre) ?></p>
        <p><span>Apellidos:</span> <?php echo htmlspecialchars($app_info->datos->apellidos) ?></p>
        <p><span>Nacionalidad:</span> <?php echo htmlspecialchars($app_info->datos->nacionalidad) ?></p>
      </div>

      <div class="card">
        <h3>Libros</h3>
        <ul>
          <?php foreach ($app_info->libros as $libro): ?>
            <li>
              <a href="cliente.php?action=get_datos_libro&id=<?php echo $libro->id ?>">
                <?php echo htmlspecialchars($libro->titulo); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

    <?php
    } elseif (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_libro") {
      $app_info = file_get_contents('http://localhost/DWES_T9/api.php?action=get_datos_libro&id=' . $_GET["id"]);
      $app_info = json_decode($app_info);
    ?>
      <div class="detalle">
        <h3>Datos del libro</h3>
        <p><span>Título:</span> <?php echo htmlspecialchars($app_info->titulo) ?></p>
        <p><span>Fecha de publicación:</span> <?php echo htmlspecialchars($app_info->f_publicacion) ?></p>
        <p><span>Autor:</span>
          <a href="cliente.php?action=get_datos_autor&id=<?php echo $app_info->id_autor ?>">
            <?php echo htmlspecialchars($app_info->nombre . " " . $app_info->apellidos) ?>
          </a>
        </p>
      </div>

    <?php
    } else {
      $lista_autores = file_get_contents('http://localhost/DWES_T9/api.php?action=get_listado_autores');
      $lista_libros  = file_get_contents('http://localhost/DWES_T9/api.php?action=get_listado_libros');
      $lista_autores = json_decode($lista_autores);
      $lista_libros  = json_decode($lista_libros);
    ?>
      <div class="search-box">
        <h3>Buscar libros</h3>
        <form id="formBusqueda" onsubmit="return validarFormulario()">
          <input
            type="text"
            id="texto"
            name="texto"
            placeholder="Escribe el título o parte de él...">
          <button type="submit" class="btn">Buscar</button>
        </form>
        <div id="resultadoBusqueda"></div>
      </div>

      <div class="cards">
        <div class="card">
          <h3>Autores</h3>
          <ul>
            <?php foreach ($lista_autores as $autor): ?>
              <li>
                <a href="cliente.php?action=get_datos_autor&id=<?php echo $autor->id ?>">
                  <?php echo htmlspecialchars($autor->nombre . " " . $autor->apellidos) ?>
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
                <a href="cliente.php?action=get_datos_libro&id=<?php echo $libro->id ?>">
                  <?php echo htmlspecialchars($libro->titulo) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php
    }
    ?>

    <div class="nav-back">
      <a href="index.php" class="btn btn-back">Volver al índice</a>
    </div>

    <div class="footer">
      <p>Helena Cristina Muñoz González</p>
      <p>DWES - Tarea 9</p>
    </div>

  </div>

</body>

</html>