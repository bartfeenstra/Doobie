<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Tests\Constraint\DateTimeConstraintEvaluatorTest.
 */

namespace BartFeenstra\Doobie\Tests\Constraint;
use BartFeenstra\Doobie\Constraint\DateTimeConstraintEvaluator;

/**
 * @coversDefaultClass \BartFeenstra\Doobie\Constraint\DateTimeConstraintEvaluator
 */
class DateTimeConstraintEvaluatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * The constraint evaluator under test.
   *
   * @var \BartFeenstra\Doobie\Constraint\DateTimeConstraintEvaluator
   */
  protected $constraintEvaluator;

  /**
   * {@inheritdoc}
   *
   * @covers ::__construct
   */
  public function setUp() {
    $this->constraintEvaluator = new DateTimeConstraintEvaluator();
  }

  /**
   * @covers ::getConstraintType
   */
  public function testGetConstraintType() {
    $this->assertSame('datetime', $this->constraintEvaluator->getConstraintType());
  }

  /**
   * @covers ::setTime
   */
  public function testSetPhpVersion() {
    $time = time() - 999;
    $this->assertSame($this->constraintEvaluator, $this->constraintEvaluator->setTime($time));
  }

  /**
   * @covers ::evaluate
   */
  public function testEvaluate() {
    $actual_timestamp = time() + 999;
    $actual_time = date(\DateTime::ISO8601, $actual_timestamp);
    $this->constraintEvaluator->setTime($actual_timestamp);

    $constraint_1 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintInterface');
    $constraint_1->expects($this->any())
      ->method('getExpectedValue')
      ->will($this->returnValue(date(\DateTime::ISO8601, $actual_timestamp - 321)));
    $constraint_1->expects($this->atLeastOnce())
      ->method('setStatus')
      ->with(TRUE);

    $constraint_2 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintInterface');
    $constraint_2->expects($this->any())
      ->method('getExpectedValue')
      ->will($this->returnValue($actual_time));
    $constraint_2->expects($this->atLeastOnce())
      ->method('setStatus')
      ->with(FALSE);

    $constraint_3 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintInterface');
    $constraint_3->expects($this->any())
      ->method('getExpectedValue')
      ->will($this->returnValue(date(\DateTime::ISO8601, $actual_timestamp + 123)));
    $constraint_3->expects($this->atLeastOnce())
      ->method('setStatus')
      ->with(FALSE);

    /** @var \PHPUnit_Framework_MockObject_MockObject[] $constraints */
    $constraints = array($constraint_1, $constraint_2, $constraint_3);
    foreach ($constraints as $constraint) {
      $constraint->expects($this->atLeastOnce())
        ->method('setActualValue')
        ->with($actual_time);
    }

    $this->constraintEvaluator->evaluate($constraints);
  }

}
