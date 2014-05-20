<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Constraint\DateTimeConstraintEvaluator.
 */

namespace BartFeenstra\Doobie\Constraint;

/**
 * Evaluates constraints for datetimes.
 *
 * The annotation looks like [doobie:datetime:2014-05-15]. Any strtotime() value
 * is allowed.
 */
class DateTimeConstraintEvaluator {

  /**
   * The timestamp to compare against.
   *
   * @var int
   *   A Unix timestamp.
   */
  protected $time;

  /**
   * Constructs a new class instance.
   */
  public function __construct() {
    $this->time = time();
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraintType() {
    return 'datetime';
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate(array $constraints) {
    /** @var \BartFeenstra\Doobie\Constraint\ConstraintInterface[] $constraints */
    foreach ($constraints as $constraint) {
      $expected_value = strtotime($constraint->getExpectedValue());
      $constraint->setStatus($expected_value < $this->time);
      $constraint->setActualValue(date(\DateTime::ISO8601, $this->time));
    }
  }

  /**
   * Sets the time to compare against.
   *
   * @param int $time
   *   A Unix timestamp.
   *
   * @return $this;
   */
  public function setTime($time) {
    $this->time = $time;

    return $this;
  }

}
