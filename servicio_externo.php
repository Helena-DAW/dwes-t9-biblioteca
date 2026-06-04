<?php

/**
 * Servicio externo - Open Library API
 * 
 * Busca libros en Open Library (API pública de terceros) y muestra
 * los resultados en una página web:
 * "Utilizar un servicio web y mostrar el resultado en una página web".
 * 
 * @package Servicio Externo
 * @author Helena Cristina Muñoz González
 * @version 1.0
 */

/**
 * Realiza una petición GET a la API de Open Library y decodifica el JSON.
 *
 * @param string $url URL completa del endpoint de Open Library.
 * @return array|null Array asociativo con los resultados, o null si hay error.
 */
function consultarOpenLibrary(string $url): ?array
{
  $resultado = @file_get_contents($url);
  if ($resultado === false) {
    return null;
  }
  $datos = json_decode($resultado, true);
  return (json_last_error() === JSON_ERROR_NONE) ? $datos : null;
}

/**
 * Busca libros en Open Library por título.
 *
 * @param string $titulo Término de búsqueda.
 * @return array|null Array con los datos de la API, o null si hay error.
 */
function buscarLibrosExternos(string $titulo): ?array
{
  $titulo = urlencode(trim($titulo));
  $url = "https://openlibrary.org/search.json?title={$titulo}&limit=12";
  return consultarOpenLibrary($url);
}

$resultados = [];
$error     = '';
$busqueda  = trim($_GET['q'] ?? '');

if ($busqueda !== '') {
  $datos = buscarLibrosExternos($busqueda);
  if ($datos === null) {
    $error = 'No se pudo conectar con Open Library. Verifica tu conexión a Internet.';
  } elseif (($datos['numFound'] ?? 0) === 0) {
    $error = "No se encontraron resultados para «{$busqueda}».";
  } else {
    $resultados = $datos['docs'] ?? [];
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buscar Libros · Open Library API</title>
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

    .header .badge {
      display: inline-block;
      background: #dbeafe;
      color: #1e40af;
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
      display: flex;
      gap: 12px;
      justify-content: center;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }

    .search-box input {
      padding: 14px 20px;
      border-radius: 10px;
      border: 1px solid var(--border);
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      width: 400px;
      max-width: 100%;
      outline: none;
      transition: border-color .2s;
    }

    .search-box input:focus {
      border-color: var(--accent);
    }

    .btn {
      padding: 14px 28px;
      border-radius: 10px;
      border: none;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      font-size: 15px;
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

    /* Error */
    .error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #991b1b;
      border-radius: 10px;
      padding: 16px 20px;
      text-align: center;
      font-weight: 500;
      margin-bottom: 24px;
    }

    .info {
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      color: #075985;
      border-radius: 10px;
      padding: 12px 20px;
      text-align: center;
      font-weight: 500;
      margin-bottom: 24px;
    }

    /* Grid resultados */
    .results-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }

    .book-card {
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 24px;
      transition: box-shadow .2s, transform .2s;
    }

    .book-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
      transform: translateY(-2px);
    }

    .book-card h3 {
      font-size: 17px;
      font-weight: 600;
      margin-bottom: 6px;
      color: var(--text);
    }

    .book-card .author {
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 8px;
    }

    .book-card .year {
      display: inline-block;
      font-size: 11px;
      font-weight: 600;
      background: #eef2ff;
      color: #4338ca;
      padding: 3px 10px;
      border-radius: 999px;
    }

    .book-card .subjects {
      margin-top: 10px;
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
    }

    .subject-tag {
      font-size: 10px;
      background: #f1f5f9;
      color: #475569;
      padding: 3px 8px;
      border-radius: 4px;
    }

    .nav-back {
      text-align: center;
      margin-top: 36px;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
      font-size: 16px;
      font-weight: bold;
      color: #2e3846;
    }
  </style>
</head>

<body>

  <div class="container">

    <div class="header">
      <span class="badge">Servicio Web de Terceros</span>
      <h1>Open Library API</h1>
      <span class="line"></span>
      <p>Busca libros en el catálogo público de Open Library usando <code>file_get_contents()</code></p>
    </div>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="servicio_externo.php">
      <div class="search-box">
        <input
          type="text"
          name="q"
          placeholder="Buscar por título (ej: The Lord of the Rings)..."
          value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit" class="btn">Buscar</button>
      </div>
    </form>

    <!-- Mensajes -->
    <?php if ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($resultados)): ?>
      <div class="info">Se encontraron <strong><?= count($resultados) ?></strong> resultados para «<?= htmlspecialchars($busqueda) ?>»</div>
    <?php endif; ?>

    <!-- Resultados -->
    <?php if (!empty($resultados)): ?>
      <div class="results-grid">
        <?php foreach ($resultados as $libro): ?>
          <?php
          $titulo    = $libro['title'] ?? 'Sin título';
          $autor     = !empty($libro['author_name']) ? implode(', ', $libro['author_name']) : 'Autor desconocido';
          $anio      = $libro['first_publish_year'] ?? null;
          $materias  = array_slice($libro['subject'] ?? [], 0, 4);
          ?>
          <div class="book-card">
            <h3><?= htmlspecialchars($titulo) ?></h3>
            <p class="author">por <?= htmlspecialchars($autor) ?></p>
            <?php if ($anio): ?>
              <span class="year"><?= $anio ?></span>
            <?php endif; ?>
            <?php if (!empty($materias)): ?>
              <div class="subjects">
                <?php foreach ($materias as $materia): ?>
                  <span class="subject-tag"><?= htmlspecialchars($materia) ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Navegación -->
    <div class="nav-back">
      <a href="index.php" class="btn btn-back">Volver al índice</a>
    </div>

    <div class="footer">
      <p>Helena Cristina Muñoz González</p>
      <p style="margin-top:6px;">DWES - Tarea 9 </p>
      <p style="margin-top:6px;">Datos obtenidos de Open Library API (openlibrary.org)</p>
    </div>

  </div>

</body>

</html>