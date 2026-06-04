<?php
class Libros
{
//CONEXIÓN CON LA DB:

  /**
   * Establece la conexion con la base de datos.
   *
   * @param string $servidor   Nombre o IP del servidor MySQL.
   * @param string $basedatos  Nombre de la base de datos.
   * @param string $usuario    Usuario de la base de datos.
   * @param string $contrasena Contraseña del usuario.
   *
   * @return mysqli|null Objeto de conexión o null si hay error.
   */


  public function conexion(
    string $servidor,
    string $basedatos,
    string $usuario,
    string $contrasena
  ): ?mysqli {
    $con = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
    if (mysqli_connect_errno()) {
      echo 'Error de conexión (' . mysqli_connect_errno() . '): '
        . mysqli_connect_error();
      return null;
    }
    mysqli_set_charset($con, 'utf8mb4');
    return $con;
  }


//CONSULTA AUTORES

  /**
   * Consulta uno o todos los autores de la base de datos.
   *
   * @param mysqli   $conexion Objeto de conexión activo.
   * @param int|null $idAutor  Id del autor a consultar, o null para todos.
   *
   * @return mysqli_result|null Resultado de la consulta o null si hay error.
   */

  public function consultarAutores(mysqli $conexion, ?int $idAutor = null): ?mysqli_result
  {
    if ($idAutor !== null) {
      $id    = mysqli_real_escape_string($conexion, (string)$idAutor);
      $query = "SELECT * FROM autor WHERE id = '$id'";
    } else {
      $query = "SELECT * FROM autor ORDER BY apellidos, nombre";
    }

    $resultado = mysqli_query($conexion, $query);
    if ($resultado === false) {
      echo 'Error en consultarAutores: ' . mysqli_error($conexion);
      return null;
    }
    return $resultado;
  }


//CONSULTA LIBROS

  /**
   * Consulta los libros de un autor concreto o todos los libros.
   *
   * @param mysqli   $conexion Objeto de conexiODn activo.
   * @param int|null $idAutor  Id del autor cuyos libros se desean, o null para todos.
   *
   * @return mysqli_result|null Resultado de la consulta o null si hay error.
   */


  public function consultarLibros(mysqli $conexion, ?int $idAutor = null): ?mysqli_result
  {
    if ($idAutor !== null) {
      $id    = mysqli_real_escape_string($conexion, (string)$idAutor);
      $query = "SELECT * FROM libro WHERE id_autor = '$id' ORDER BY f_publicacion";
    } else {
      $query = "SELECT * FROM libro ORDER BY id_autor, f_publicacion";
    }

    $resultado = mysqli_query($conexion, $query);
    if ($resultado === false) {
      echo 'Error en consultarLibros: ' . mysqli_error($conexion);
      return null;
    }

    return $resultado;
  }


//CONSULTA DATOS LIBRO
  /**
   * Consulta los datos completos de un libro en concreto.
   *
   * @param mysqli $conexion Objeto de conexion activo.
   * @param int    $idLibro ID del libro que se desea consultar.
   *
   * @return mysqli_result|null Resultado de la consulta o null si hay un error.
   */


  public function consultarDatosLibro(mysqli $conexion, int $idLibro): ?mysqli_result
  {
    $id    = mysqli_real_escape_string($conexion, (string)$idLibro);
    $query = "SELECT l.*, a.nombre, a.apellidos
              FROM libro l
              INNER JOIN autor a ON l.id_autor = a.id
              WHERE l.id = '$id'";

    $resultado = mysqli_query($conexion, $query);
    if ($resultado === false) {
      echo 'Error en consultarDatosLibro: ' . mysqli_error($conexion);
      return null;
    }
    return $resultado;
  }


//BORRAR AUTOR
  /**
   * Elimina un autor de la base de datos por su id.
   *
   * @param mysqli $conexion Objeto de conexión activo.
   * @param int    $idAutor  Id del autor que se desea eliminar.
   *
   * @return bool true si se borró correctamente, false en caso de error.
   */


  public function borrarAutor(mysqli $conexion, int $idAutor): bool
  {
    $id    = mysqli_real_escape_string($conexion, (string)$idAutor);
    $query = "DELETE FROM autor WHERE id = '$id'";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado === false) {
      echo 'Error en borrarAutor: ' . mysqli_error($conexion);
      return false;
    }
    return mysqli_affected_rows($conexion) > 0;
  }


//BORRAR LIBRO

  /**
   * Elimina un libro de la base de datos usando su id
   *
   * @param mysqli $conexion Objeto de conexion activo.
   * @param int    $idLibro Id del libro que se desea eliminar.
   *
   * @return bool true si se borró correctamente, false en caso de error
   */

  public function borrarLibro(mysqli $conexion, int $idLibro): bool
  {
    $id    = mysqli_real_escape_string($conexion, (string)$idLibro);
    $query = "DELETE FROM libro WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $query);
    if ($resultado === false) {
      echo 'Error en borrarLibro(): ' . mysqli_error($conexion);
      return false;
    }

    return mysqli_affected_rows($conexion) > 0;
  }

  //BUSCADOR DE LIBROS
  /**
   * Busca libros cuyo título contiene el texto indicado.
   *
   * @param mysqli $conexion Objeto de conexión activo.
   * @param string $texto    Texto a buscar dentro del título del libro.
   *
   * @return mysqli_result|null Resultado de la consulta o null si hay error.
   */

  public function buscarLibrosPorTitulo(mysqli $conexion, string $texto): ?mysqli_result
  {
    $textoBuscado = mysqli_real_escape_string($conexion, $texto);
    $query = "SELECT l.*, a.nombre, a.apellidos
                FROM libro l
                INNER JOIN autor a ON l.id_autor = a.id
                WHERE l.titulo LIKE '%$textoBuscado%'
                ORDER BY l.titulo";

    $resultado = mysqli_query($conexion, $query);
    if ($resultado === false) {
      echo 'Error en buscarLibrosPorTitulo: ' . mysqli_error($conexion);
      return null;
    }
    return $resultado;
  }
}
