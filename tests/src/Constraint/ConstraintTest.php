<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Tests\Constraint\ConstraintTest.
 */

namespace BartFeenstra\Doobie\Tests\Constraint;
use BartFeenstra\Doobie\Constraint\Constraint;

/**
 * @coversDefaultClass \BartFeenstra\Doobie\Constraint\Constraint
 */
class ConstraintTest extends \PHPUnit_Framework_TestCase {

  /**
   * The constraint under test.
   *
   * @var \BartFeenstra\Doobie\Constraint\Constraint
   */
  protected $constraint;

  /**
   * The expected constraint value.
   *
   * @var string
   */
  protected $expectedValue;

  /**
   * The name of the file the constraint is defined in.
   *
   * @var string
   */
  protected $fileName;

  /**
   * The number of the line the constraint is defined on.
   *
   * @var string
   */
  protected $lineNumber;

  /**
   * The constraint type.
   *
   * @var string
   */
  protected $type;

  /**
   * {@inheritdoc}
   *
   * @covers ::__construct
   */
  public function setUp() {
    $this->expectedValue = 'foobarbaz';
    $this->filename = __FILE__;
    $this->lineNumber = mt_rand();
    $this->type = 'qux';
    $this->constraint = new Constraint($this->type, $this->expectedValue, $this->fileName, $this->lineNumber);
  }

  /**
   * @covers ::getExpectedValue
   */
  public function testGetExpectedValue() {
    $this->assertSame($this->expectedValue, $this->constraint->getExpectedValue());
  }

  /**
   * @covers ::getFileName
   */
  public function testGetFileName() {
    $this->assertSame($this->fileName, $this->constraint->getFileName());
  }

  /**
   * @covers ::getLineNumber
   */
  public function testGetLineNumber() {
    $this->assertSame($this->lineNumber, $this->constraint->getLineNumber());
  }

  /**
   * @covers ::getType
   */
  public function testGetType() {
    $this->assertSame($this->type, $this->constraint->getType());
  }

  /**
   * @covers ::setStatus
   * @covers ::getStatus
   */
  public function testGetStatus() {
    $this->assertSame($this->constraint, $this->constraint->setStatus(TRUE));
    $this->assertTrue($this->constraint->getStatus());
    $this->constraint->setStatus(FALSE);
    $this->assertFalse($this->constraint->getStatus());
  }

  /**
   * @covers ::setActualValue
   * @covers ::getActualValue
   */
  public function testGetActualValue() {
    $actual_value = 'barfoo';
    $this->assertSame($this->constraint, $this->constraint->setActualValue($actual_value));
    $this->assertSame($actual_value, $this->constraint->getActualValue());
  }

}
