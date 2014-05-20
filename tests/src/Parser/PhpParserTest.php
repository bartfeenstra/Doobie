<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Tests\Parser\PhpParserTest.
 */

namespace BartFeenstra\Doobie\Tests\Parser;

use BartFeenstra\Doobie\Parser\PhpParser;

/**
 * @coversDefaultClass \BartFeenstra\Doobie\Parser\PhpParser
 */
class PhpParserTest extends \PHPUnit_Framework_TestCase {

  /**
   * The parser under test.
   *
   * @var \BartFeenstra\Doobie\Parser\PhpParser
   */
  protected $parser;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->parser = new PhpParser();
  }

  /**
   * @covers ::parse
   */
  public function testGetExpectedValue() {
    $path_to_data = __DIR__ . '/../../data/php';
    $path_to_foo = $path_to_data . '/Foo.php';
    $path_to_bar = $path_to_data . '/bar/Bar.php';
    $file_names = array(
      $path_to_foo,
      $path_to_bar,
    );

    /** @var \BartFeenstra\Doobie\Constraint\ConstraintInterface[] $constraints */
    $constraints = $this->parser->parse($file_names);
    $this->assertCount(6, $constraints);

    $this->assertSame('bar', $constraints[0]->getType());
    $this->assertSame('baz', $constraints[0]->getExpectedValue());
    $this->assertSame($path_to_foo, $constraints[0]->getFileName());
    $this->assertSame(7, $constraints[0]->getLineNumber());

    $this->assertSame('foo', $constraints[1]->getType());
    $this->assertSame('foo', $constraints[1]->getExpectedValue());
    $this->assertSame($path_to_foo, $constraints[1]->getFileName());
    $this->assertSame(13, $constraints[1]->getLineNumber());

    $this->assertSame('foo', $constraints[2]->getType());
    $this->assertSame('qux', $constraints[2]->getExpectedValue());
    $this->assertSame($path_to_foo, $constraints[2]->getFileName());
    $this->assertSame(21, $constraints[2]->getLineNumber());

    $this->assertSame('foo', $constraints[3]->getType());
    $this->assertSame('baz', $constraints[3]->getExpectedValue());
    $this->assertSame($path_to_bar, $constraints[3]->getFileName());
    $this->assertSame(7, $constraints[3]->getLineNumber());

    $this->assertSame('foo', $constraints[4]->getType());
    $this->assertSame('foo', $constraints[4]->getExpectedValue());
    $this->assertSame($path_to_bar, $constraints[4]->getFileName());
    $this->assertSame(15, $constraints[4]->getLineNumber());

    $this->assertSame('foo', $constraints[5]->getType());
    $this->assertSame('qux', $constraints[5]->getExpectedValue());
    $this->assertSame($path_to_bar, $constraints[5]->getFileName());
    $this->assertSame(23, $constraints[5]->getLineNumber());
  }

}
