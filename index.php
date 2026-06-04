<?php

/**
 * Página principal de la Tarea 9 - DWES
 * 
 * Índice de navegación que da acceso a todas las secciones de la tarea:
 * - Cliente de la API de Biblioteca
 * - Documentación generada con phpDocumentor
 * - Pruebas unitarias
 * - Repositorio en GitHub
 * 
 * @package DWES_T9
 * @author Helena Cristina Muñoz González
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarea 9 - DWES | Biblioteca API</title>
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
      --border-hover: #94a3b8;
      --shadow-card: 0 1px 3px rgba(0, 0, 0, .06), 0 8px 20px rgba(0, 0, 0, .06);
      --shadow-card-hover: 0 4px 8px rgba(0, 0, 0, .08), 0 12px 32px rgba(0, 0, 0, .12);
      --tag-api: #dbeafe;
      --tag-api-text: #1e40af;
      --tag-app: #dcfce7;
      --tag-app-text: #166534;
      --tag-doc: #fef3c7;
      --tag-doc-text: #92400e;
      --tag-repo: #f3e8ff;
      --tag-repo-text: #6b21a8;
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
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 32px;
    }

    .container {
      width: 100%;
      max-width: 1100px;
      background: var(--card-bg);
      border-radius: 24px;
      box-shadow: var(--shadow-card);
      padding: 80px 72px;
      border: 1px solid var(--border);
    }

    @media (max-width: 800px) {
      .container {
        padding: 48px 28px;
      }

      body {
        padding: 24px 16px;
      }
    }

    /* ── HEADER ── */
    .header {
      margin-bottom: 60px;
    }

    .header h1 {
      font-size: 40px;
      font-weight: 700;
      color: var(--text);
      letter-spacing: -1px;
      margin-bottom: 6px;
    }

    .header .line {
      display: inline-block;
      width: 56px;
      height: 5px;
      background: var(--accent);
      border-radius: 3px;
      margin-top: 12px;
    }

    .header p {
      font-size: 18px;
      color: var(--text-secondary);
      margin-top: 14px;
      font-weight: 500;
    }

    /* ── GRID ── */
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 24px;
    }

    @media (max-width: 650px) {
      .grid {
        grid-template-columns: 1fr;
      }
    }

    /* ── CARDS ── */
    .card {
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 40px 36px;
      text-decoration: none;
      color: inherit;
      display: flex;
      flex-direction: column;
      gap: 14px;
      transition: border-color .2s, box-shadow .2s, transform .2s;
      background: var(--card-bg);
      position: relative;
      overflow: hidden;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
    }

    .card:nth-child(1)::before {
      background: #16a34a;
    }

    .card:nth-child(2)::before {
      background: #0891b2;
    }

    .card:nth-child(3)::before {
      background: #d97706;
    }

    .card:nth-child(4)::before {
      background: #7c3aed;
    }

    .card:hover {
      border-color: var(--border-hover);
      box-shadow: var(--shadow-card-hover);
      transform: translateY(-4px);
    }

    .card-tag {
      display: inline-block;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding: 5px 14px;
      border-radius: 999px;
      width: fit-content;
    }

    .card:nth-child(1) .card-tag {
      background: var(--tag-app);
      color: var(--tag-app-text);
    }

    .card:nth-child(2) .card-tag {
      background: #cffafe;
      color: #155e75;
    }

    .card:nth-child(3) .card-tag {
      background: var(--tag-doc);
      color: var(--tag-doc-text);
    }

    .card:nth-child(4) .card-tag {
      background: var(--tag-repo);
      color: var(--tag-repo-text);
    }

    .card-title {
      font-size: 22px;
      font-weight: 700;
      color: var(--text);
    }

    .card-desc {
      font-size: 16px;
      color: var(--text-secondary);
      line-height: 1.7;
    }

    /* ── FOOTER ── */
    .footer {
      margin-top: 56px;
      padding-top: 28px;
      border-top: 1px solid var(--border);
      text-align: center;
      font-size: 18px;
      font-weight: bold;
      color: #1b2e49;
      line-height: 2;
    }
  </style>
</head>

<body>

  <div class="container">

    <div class="header">
      <h1>DWES - Tarea 9</h1>
      <span class="line"></span>
      <p>Desarrollo de aplicaciones Web híbridas</p>
    </div>

    <div class="grid">

      <a href="cliente.php" class="card">
        <span class="card-tag">Aplicación</span>
        <span class="card-title">Cliente de Biblioteca</span>
        <span class="card-desc">Explora autores y libros con búsqueda en tiempo real mediante AJAX.</span>
      </a>

      <a href="doc/index.html" class="card">
        <span class="card-tag">Documentación</span>
        <span class="card-title">PHPDoc</span>
        <span class="card-desc">Documentación técnica generada con phpDocumentor.</span>
      </a>

      <a href="servicio_externo.php" class="card">
        <span class="card-tag">Servicio Externo</span>
        <span class="card-title">Open Library API</span>
        <span class="card-desc">Busca libros en el catálogo público de Open Library mediante file_get_contents().</span>
      </a>

      <a href="https://github.com/Helena-DAW/dwes-t9-biblioteca" target="_blank" class="card">
        <span class="card-tag">Repositorio</span>
        <span class="card-title">GitHub</span>
        <span class="card-desc">Código fuente completo del proyecto bajo control de versiones.</span>
      </a>

    </div>

    <div class="footer">
      <p>Helena Cristina Muñoz González</p>
      <p>DWES - Tarea 9</p>
    </div>

  </div>

</body>

</html>