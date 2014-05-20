<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Tests\FileFinder\PhpFileFinderTest.
 */

namespace BartFeenstra\Doobie\Tests\FileFinder;

use BartFeenstra\Doobie\FileFinder\PhpFileFinder;

/**
 * @coversDefaultClass \BartFeenstra\Doobie\FileFinder\PhpFileFinder
 */
class PhpFileFinderTest extends \PHPUnit_Framework_TestCase {

  /**
   * The file finder under test.
   *
   * @var \BartFeenstra\Doobie\FileFinder\PhpFileFinder
   */
  protected $fileFinder;

  /**
   * {@inheritdoc}
   *
   * @covers ::__construct
   */
  public function setUp() {
    $this->fileFinder = new PhpFileFinder(__DIR__ . '/../../data/php', 'php');
  }

  /**
   * @covers ::getFileNames
   */
  public function testGetFileNames() {
    $path_to_data = __DIR__ . '/../../data/php';
    $path_to_foo = $path_to_data . '/Foo.php';
    $path_to_bar = $path_to_data . '/bar/Bar.php';
    $file_names = $this->fileFinder->getFileNames();
    $this->assertTrue(in_array($path_to_foo, $file_names));
    $this->assertTrue(in_array($path_to_bar, $file_names));
  }

}
