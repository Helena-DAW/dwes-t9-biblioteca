<?php

/*--- Abrimos Conexion a la BD, incluimos la clase Libros de Libros.php ---*/

require_once('Libros.php');
$librosObj = new Libros();
$conexion  = $librosObj->conexion('localhost', 'libros', 'root', '');

/*--- FUNCIONES ---*/

/**
 * Recupera todos los autores de la base de datos.
 *
 * @return array Lista de objetos con los datos de cada autor.
 */
function get_listado_autores()
{
  global $conexion;
  global $librosObj;
  $resultado = $librosObj->consultarAutores($conexion);
  $listaAutores = [];

  if ($resultado) {
    while ($fila = $resultado->fetch_object())
      $listaAutores[] = $fila;
    $resultado->free();
  }
  return $listaAutores;
}

/**
 * Recupera los datos de un autor y su lista de libros de la base de datos.
 *
 * @param int $id Id del autor a consultar.
 * @return stdClass Objeto con dos propiedades: datos (autor) y libros (lista de libros).
 */
function get_datos_autor($id)
{
  global $conexion;
  global $librosObj;
  $resultado = $librosObj->consultarAutores($conexion, $id);
  $autor = $resultado->fetch_object();
  $resultadoLibros =  $librosObj->consultarLibros($conexion, $id);
  $listaLibros = [];
  if ($resultadoLibros) {
    while ($libro = $resultadoLibros->fetch_object()) {
      $listaLibros[] = $libro;
    }
    $resultadoLibros->free();
  }

  $info_autor = new stdClass();
  $info_autor->datos = $autor;
  $info_autor->libros = $listaLibros;
  return $info_autor;
}

/**
 * Recupera todos los libros de la base de datos.
 *
 * @return array Lista de objetos con los datos de cada libro.
 */
function get_listado_libros()
{
  global $conexion;
  global $librosObj;

  $resultado = $librosObj->consultarLibros($conexion);
  $listaLibros = [];

  if ($resultado) {
    while ($fila = $resultado->fetch_object())
      $listaLibros[] = $fila;
    $resultado->free();
  }
  return $listaLibros;
}

/**
 * Recupera los datos de un libro junto con el nombre y apellidos de su autor.
 *
 * @param int $id Id del libro a consultar.
 * @return stdClass Objeto con los campos titulo, f_publicacion, id_autor, nombre y apellidos.
 */
function get_datos_libro($id)
{
  global $conexion;
  global $librosObj;
  $resultado = $librosObj->consultarDatosLibro($conexion, $id);
  $libro = $resultado->fetch_object();
  return $libro;
}


/**
 * Busca libros cuyo título contiene el texto recibido por GET.
 *
 * @param string $texto Texto a buscar en el título del libro.
 * @return array Lista de objetos con los datos de los libros encontrados.
 */
function buscar_libros(string $texto): array
{
  global $conexion, $librosObj;
  $resultado = $librosObj->buscarLibrosPorTitulo($conexion, $texto);
  $listaLibros = [];
  if ($resultado) {
    while ($fila = $resultado->fetch_object())
      $listaLibros[] = $fila;
    $resultado->free();
  }
  return $listaLibros;
}

/*--- URL ---*/
$posibles_URL = array("get_listado_autores", "get_datos_autor", "get_listado_libros", "get_datos_libro", "buscar_libros");


/*--- SWITCH ---*/
$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL)) {
  switch ($_GET["action"]) {
    case "get_listado_autores":
      $valor = get_listado_autores();
      break;
    case "get_datos_autor":
      if (isset($_GET["id"]))
        $valor = get_datos_autor($_GET["id"]);
      else
        $valor = "Argumento no encontrado";
      break;
    case "get_listado_libros":
      $valor = get_listado_libros();
      break;
    case "get_datos_libro":
      if (isset($_GET["id"]))
        $valor = get_datos_libro($_GET["id"]);
      else
        $valor = "Argumento no encontrado";
      break;
    // NUEVA FUNCIÓN buscar_libros
    case "buscar_libros":
      if (isset($_GET["texto"]))
        $valor = buscar_libros($_GET["texto"]);
      else
        $valor = "Argumento no encontrado";
      break;
  }
}

exit(json_encode($valor));
