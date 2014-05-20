<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Constraint\ConstraintEvaluatorInterface.
 */

namespace BartFeenstra\Doobie\Constraint;

/**
 * Defines a constraint evaluator.
 */
interface ConstraintEvaluatorInterface {

  /**
   * Gets the constraint type.
   *
   * @return string
   */
  public function getConstraintType();

  /**
   * Evaluates constraints for this constraint type.
   *
   * @param \BartFeenstra\Doobie\Constraint\ConstraintInterface[] $constraints
   */
  public function evaluate(array $constraints);

}
