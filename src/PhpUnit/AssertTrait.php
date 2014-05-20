<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\PhpUnit\AssertTrait.
 */

namespace BartFeenstra\Doobie\PhpUnit;

trait AssertTrait {

  /**
   * Asserts that no Doobie markers have expired.
   *
   * @param \BartFeenstra\Doobie\FileFinder\FileFinderInterface[] $file_finders
   * @param \BartFeenstra\Doobie\Parser\ParserInterface[] $parsers
   * @param \BartFeenstra\Doobie\Constraint\ConstraintEvaluatorInterface[] $constraint_evaluators
   */
  public function assertDoobieMarkers(array $file_finders, array $parsers, array $constraint_evaluators) {
    $constraint = new DoobieMarkerAssert($file_finders, $parsers, $constraint_evaluators);

    \PHPUnit_Framework_TestCase::assertThat(NULL, $constraint);
  }

}
