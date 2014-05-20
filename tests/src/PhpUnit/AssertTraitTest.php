<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Tests\PhpUnit\DoobieMarkerAssertTest.
 */

namespace BartFeenstra\Doobie\Tests\Parser;

use BartFeenstra\Doobie\PhpUnit\AssertTrait;

/**
 * @coversDefaultClass \BartFeenstra\Doobie\PhpUnit\AssertTrait
 */
class AssertTraitTest extends \PHPUnit_Framework_TestCase {

  /**
   * The trait under test.
   *
   * @var \BartFeenstra\Doobie\PhpUnit\AssertTrait
   */
  protected $trait;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->trait = new AssertTraitTestWrapper();
  }

  /**
   * @covers ::assertDoobieMarkers
   */
  public function testAssertDoobieMarkers() {
    $file_path = 'barfoo';

    $constraint = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintInterface');
    // Make sure this constraint has not expired, or it will show up as a
    // failure in *this* test.
    $constraint->expects($this->any())
      ->method('getStatus')
      ->will($this->returnValue(TRUE));

    $file_finder = $this->getMock('\BartFeenstra\Doobie\FileFinder\FileFinderInterface');
    $file_finder ->expects($this->once())
      ->method('getFilenames')
      ->will($this->returnValue(array($file_path)));

    $parser = $this->getMock('\BartFeenstra\Doobie\Parser\ParserInterface');
    $parser->expects($this->once())
      ->method('parse')
      ->with(array($file_path))
      ->will($this->returnValue(array($constraint)));

    $constraint_evaluator = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintEvaluatorInterface');
    $constraint_evaluator->expects($this->once())
      ->method('evaluate')
      ->with(array($constraint));

    $this->trait->assertDoobieMarkers(array($file_finder), array($parser), array($constraint_evaluator));
  }

}

/**
 * Uses \BartFeenstra\Doobie\PhpUnit\AssertTrait.
 */
class AssertTraitTestWrapper {

  use AssertTrait;

}
