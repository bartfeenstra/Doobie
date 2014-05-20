<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\PhpUnit\DoobieMarkerAssert.
 */

namespace BartFeenstra\Doobie\PhpUnit;

/**
 * Asserts no Doobie markers have expired.
 */
class DoobieMarkerAssert extends \PHPUnit_Framework_Constraint {

  /**
   * The evaluated constraints.
   *
   * @var \BartFeenstra\Doobie\Constraint\ConstraintInterface[]
   */
  protected $constraints = array();

  /**
   * The constraint evaluators.
   *
   * @var \BartFeenstra\Doobie\Constraint\ConstraintEvaluatorInterface[]
   */
  protected $constraintEvaluators = array();

  /**
   * The file finders.
   *
   * @var \BartFeenstra\Doobie\FileFinder\FileFinderInterface[]
   */
  protected $fileFinders = array();

  /**
   * The parsers.
   *
   * @var \BartFeenstra\Doobie\Parser\ParserInterface[]
   */
  protected $parsers = array();

  /**
   * Constructs a new class instance.
   *
   * @param \BartFeenstra\Doobie\FileFinder\FileFinderInterface[] $file_finders
   * @param \BartFeenstra\Doobie\Parser\ParserInterface[] $parsers
   * @param \BartFeenstra\Doobie\Constraint\ConstraintEvaluatorInterface[] $constraint_evaluators
   */
  public function __construct(array $file_finders, array $parsers, array $constraint_evaluators) {
    $this->constraintEvaluators = $constraint_evaluators;
    $this->fileFinders = $file_finders;
    $this->parsers = $parsers;
  }

  /**
   * {@inheritdoc}
   */
  protected function matches($other) {
    $file_names = array();
    foreach ($this->fileFinders as $file_finder) {
      $file_names = array_merge($file_names, $file_finder->getFileNames());
    }

    $constraints_per_type = array();
    foreach ($this->parsers as $parser) {
      foreach ($parser->parse($file_names) as $constraint) {
        $this->constraints[] = $constraint;
        $constraints_per_type[$constraint->getType()][] = $constraint;
      }
    }

    foreach ($this->constraintEvaluators as $constraint_evaluator) {
      if (isset($constraints_per_type[$constraint_evaluator->getConstraintType()])) {
        $constraint_evaluator->evaluate($constraints_per_type[$constraint_evaluator->getConstraintType()]);
      }
    }

    $success = TRUE;
    foreach ($constraints_per_type as $constraints) {
      /** @var \BartFeenstra\Doobie\Constraint\ConstraintInterface[] $constraints */
      foreach ($constraints as $constraint) {
        if (!$constraint->getStatus()) {
          $success = FALSE;
          break 2;
        }
      }
    }
    return $success;
  }

  /**
   * {@inheritdoc}
   */
  public function toString() {
    return 'there are no expired @todo annotations in the code';
  }

  /**
   * {@inheritdoc}
   */
  protected function failureDescription($other) {
    return $this->toString();
  }

  /**
   * {@inheritdoc}
   */
  protected function additionalFailureDescription($other) {
    $description = "The following @todo annotations have expired:";
    foreach ($this->constraints as $constraint) {
      if (!$constraint->getStatus()) {
        $description .= sprintf("\n- [doobie:%s:%s] on line %d of %s. The actual value is %s.", $constraint->getType(), $constraint->getExpectedValue(), $constraint->getLineNumber(), $constraint->getFileName(), $constraint->getActualValue());
      }
    }

    return $description;
  }
}
