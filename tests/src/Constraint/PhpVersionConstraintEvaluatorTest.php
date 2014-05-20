<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Tests\Constraint\PhpVersionConstraintEvaluatorTest.
 */

namespace BartFeenstra\Doobie\Tests\Constraint;
use BartFeenstra\Doobie\Constraint\PhpVersionConstraintEvaluator;

/**
 * @coversDefaultClass \BartFeenstra\Doobie\Constraint\PhpVersionConstraintEvaluator
 */
class PhpVersionConstraintEvaluatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * The constraint evaluator under test.
   *
   * @var \BartFeenstra\Doobie\Constraint\PhpVersionConstraintEvaluator
   */
  protected $constraintEvaluator;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->constraintEvaluator = new PhpVersionConstraintEvaluator();
  }

  /**
   * @covers ::getConstraintType
   */
  public function testGetConstraintType() {
    $this->assertSame('php-version', $this->constraintEvaluator->getConstraintType());
  }

  /**
   * @covers ::setPhpVersion
   */
  public function testSetPhpVersion() {
    $this->assertSame($this->constraintEvaluator, $this->constraintEvaluator->setPhpVersion('foo'));
  }

  /**
   * @covers ::evaluate
   */
  public function testEvaluate() {
    $actual_php_version = '5.4.3';
    $this->constraintEvaluator->setPhpVersion($actual_php_version);

    $constraint_1 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintInterface');
    $constraint_1->expects($this->any())
      ->method('getExpectedValue')
      ->will($this->returnValue('5.4.3'));
    $constraint_1->expects($this->atLeastOnce())
      ->method('setStatus')
      ->with(TRUE);

    $constraint_2 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintInterface');
    $constraint_2->expects($this->any())
      ->method('getExpectedValue')
      ->will($this->returnValue('>5.4.3'));
    $constraint_2->expects($this->atLeastOnce())
      ->method('setStatus')
      ->with(FALSE);

    /** @var \PHPUnit_Framework_MockObject_MockObject[] $constraints */
    $constraints = array($constraint_1, $constraint_2);
    foreach ($constraints as $constraint) {
      $constraint->expects($this->atLeastOnce())
        ->method('setActualValue')
        ->with($actual_php_version);
    }

    $this->constraintEvaluator->evaluate($constraints);
  }

}
