<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Tests\PhpUnit\DoobieMarkerAssertTest.
 */

namespace BartFeenstra\Doobie\Tests\Parser;

use BartFeenstra\Doobie\PhpUnit\DoobieMarkerAssert;

/**
 * @coversDefaultClass \BartFeenstra\Doobie\PhpUnit\DoobieMarkerAssert
 */
class DoobieMarkerAssertTest extends \PHPUnit_Framework_TestCase {

  /**
   * The assert under test.
   *
   * @var \BartFeenstra\Doobie\PhpUnit\DoobieMarkerAssert
   */
  protected $assert;

  /**
   * The evaluated constraints.
   *
   * @var \BartFeenstra\Doobie\Constraint\ConstraintInterface|\PHPUnit_Framework_MockObject_MockObject[]
   */
  protected $constraints = array();

  /**
   * The constraint evaluators.
   *
   * @var \BartFeenstra\Doobie\Constraint\ConstraintEvaluatorInterface|\PHPUnit_Framework_MockObject_MockObject[]
   */
  protected $constraintEvaluators = array();

  /**
   * The file finders.
   *
   * @var \BartFeenstra\Doobie\FileFinder\FileFinderInterface|\PHPUnit_Framework_MockObject_MockObject[]
   */
  protected $fileFinders = array();

  /**
   * The parsers.
   *
   * @var \BartFeenstra\Doobie\Parser\ParserInterface|\PHPUnit_Framework_MockObject_MockObject[]
   */
  protected $parsers = array();

  /**
   * {@inheritdoc}
   *
   * @covers ::__construct
   */
  public function setUp() {
    $constraint_1 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintInterface');
    $constraint_2 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintInterface');
    $this->constraints = array($constraint_1, $constraint_2);

    $file_finder_1 = $this->getMock('\BartFeenstra\Doobie\FileFinder\FileFinderInterface');
    $file_finder_2 = $this->getMock('\BartFeenstra\Doobie\FileFinder\FileFinderInterface');
    $this->fileFinders = array($file_finder_1, $file_finder_2);

    $parser_1 = $this->getMock('\BartFeenstra\Doobie\Parser\ParserInterface');
    $parser_2 = $this->getMock('\BartFeenstra\Doobie\Parser\ParserInterface');
    $this->parsers = array($parser_1, $parser_2);

    $constraint_evaluator_1 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintEvaluatorInterface');
    $constraint_evaluator_2 = $this->getMock('\BartFeenstra\Doobie\Constraint\ConstraintEvaluatorInterface');
    $this->constraintEvaluators = array($constraint_evaluator_1, $constraint_evaluator_2);

    $this->assert = new DoobieMarkerAssert($this->fileFinders, $this->parsers, $this->constraintEvaluators);
  }

  /**
   * @covers ::toString
   */
  public function testToString() {
    $this->assertInternalType('string', $this->assert->toString());
  }

  /**
   * @covers ::failureDescription
   */
  public function testFailureDescription() {
    $method = new \ReflectionMethod($this->assert, 'failureDescription');
    $method->setAccessible(TRUE);
    $other = 'foo';

    $this->assertInternalType('string', $method->invoke($this->assert, $other));
  }

  /**
   * @covers ::additionalFailureDescription
   */
  public function testAdditionalFailureDescription() {
    $constraint_type_2 = 'baz';
    $constraint_actual_value_2 = 'qux';
    $constraint_expected_value_2 = 'foo';
    $constraint_line_number_2 = mt_rand();
    $constraint_file_name_2 = 'bar';

    $this->constraints[0]->expects($this->once())
      ->method('getStatus')
      ->will($this->returnValue(TRUE));

    $this->constraints[1]->expects($this->once())
      ->method('getActualValue')
      ->will($this->returnValue($constraint_actual_value_2));
    $this->constraints[1]->expects($this->once())
      ->method('getExpectedValue')
      ->will($this->returnValue($constraint_expected_value_2));
    $this->constraints[1]->expects($this->once())
      ->method('getFileName')
      ->will($this->returnValue($constraint_file_name_2));
    $this->constraints[1]->expects($this->once())
      ->method('getLineNumber')
      ->will($this->returnValue($constraint_line_number_2));
    $this->constraints[1]->expects($this->once())
      ->method('getStatus')
      ->will($this->returnValue(FALSE));
    $this->constraints[1]->expects($this->once())
      ->method('getType')
      ->will($this->returnValue($constraint_type_2));

    $property = new \ReflectionProperty($this->assert, 'constraints');
    $property->setAccessible(TRUE);
    $property->setValue($this->assert, $this->constraints);

    $method = new \ReflectionMethod($this->assert, 'additionalFailureDescription');
    $method->setAccessible(TRUE);
    $other = 'foo';

    $expected_value = 'The following @todo annotations have expired:
- [doobie:baz:foo] on line ' . $constraint_line_number_2 . ' of bar. The actual value is qux.';
    $this->assertSame($expected_value, $method->invoke($this->assert, $other));
  }

  /**
   * @covers ::matches
   */
  public function testMatches() {
    $path_to_data = __DIR__ . '/../../data/php';
    $path_to_foo = $path_to_data . '/Foo.php';
    $path_to_bar = $path_to_data . '/bar/Bar.php';

    $this->constraints[0]->expects($this->once())
      ->method('getStatus')
      ->will($this->returnValue(TRUE));

    $this->constraints[1]->expects($this->once())
      ->method('getStatus')
      ->will($this->returnValue(FALSE));

    $this->fileFinders[0]->expects($this->once())
      ->method('getFileNames')
      ->will($this->returnValue(array($path_to_foo)));

    $this->fileFinders[1]->expects($this->once())
      ->method('getFileNames')
      ->will($this->returnValue(array($path_to_bar)));

    $this->parsers[0]->expects($this->once())
      ->method('parse')
      ->with(array($path_to_foo, $path_to_bar))
      ->will($this->returnValue(array($this->constraints[0])));

    $this->parsers[1]->expects($this->once())
      ->method('parse')
      ->with(array($path_to_foo, $path_to_bar))
      ->will($this->returnValue(array($this->constraints[1])));

    $method = new \ReflectionMethod($this->assert, 'matches');
    $method->setAccessible(TRUE);
    $other = 'foo';
    $method->invoke($this->assert, $other);
  }

}
