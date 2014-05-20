<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Constraint\ConstraintInterface.
 */

namespace BartFeenstra\Doobie\Constraint;

/**
 * Defines a constraint.
 */
interface ConstraintInterface {

  /**
   * Gets the constraint type.
   *
   * @return string
   */
  public function getType();

  /**
   * Gets the expected constraint value.
   *
   * @return mixed
   */
  public function getExpectedValue();

  /**
   * Sets the actual constraint value.
   *
   * @param mixed $value
   *
   * @return $this
   */
  public function setActualValue($value);

  /**
   * Gets the actual constraint value.
   *
   * @return mixed
   */
  public function getActualValue();

  /**
   * Sets the status.
   *
   * @param bool $status
   *   TRUE if the constraint matches, FALSE if it no longer does.
   *
   * @return $this
   */
  public function setStatus($status);

  /**
   * Gets the status.
   *
   * @return bool
   *   TRUE if the constraint matches, FALSE if it no longer does.
   */
  public function getStatus();

  /**
   * Gets the name of the file the constraint is defined in.
   *
   * @return string
   */
  public function getFileName();

  /**
   * Gets the number of the line the constraint is defined on.
   *
   * @return string
   */
  public function getLineNumber();

}
