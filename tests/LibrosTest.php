<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Libros.php';

//TESTS PHPUNIT

final class LibrosTest extends TestCase
{
  private static Libros $libros;
  private static ?mysqli $con = null;
  public static function setUpBeforeClass(): void

  {
    self::$libros = new Libros();
    self::$con    = self::$libros->conexion('localhost', 'libros', 'root', '');
  }

  public static function tearDownAfterClass(): void
  {
    if (self::$con !== null) {
      mysqli_close(self::$con);
    }
  }

  public function testConexionExitosa(): void
  {
    $this->assertInstanceOf(mysqli::class, self::$con);
  }

  public function testConsultarTodosLosAutores(): void
  {
    $res = self::$libros->consultarAutores(self::$con);
    $this->assertInstanceOf(mysqli_result::class, $res);
    $this->assertGreaterThan(0, $res->num_rows);
    $res->free();
  }

  public function testConsultarAutorPorId(): void
  {
    $res = self::$libros->consultarAutores(self::$con, 1);
    $this->assertEquals(1, $res->num_rows);
    $res->free();
  }

  public function testConsultarLibrosPorAutor(): void
  {
    $res = self::$libros->consultarLibros(self::$con, 0);
    $this->assertGreaterThan(0, $res->num_rows);
    $res->free();
  }

  public function testConsultarDatosLibro(): void
  {
    $res = self::$libros->consultarDatosLibro(self::$con, 1);
    $this->assertEquals(1, $res->num_rows);
    $res->free();
  }

  public function testBorrarLibro(): void
  {
    $resultado = self::$libros->borrarLibro(self::$con, 6);
    $this->assertTrue($resultado);
  }

  public function testBorrarAutor(): void
  {
    $resultado = self::$libros->borrarAutor(self::$con, 1);
    $this->assertTrue($resultado);
  }
}
