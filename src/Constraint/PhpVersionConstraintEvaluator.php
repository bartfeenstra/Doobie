<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Constraint\PhpVersionConstraintEvaluator.
 */

namespace BartFeenstra\Doobie\Constraint;

/**
 * Evaluates constraints for PHP versions.
 *
 * The annotation looks like [doobie:php-version:>=5.4.2].
 */
class PhpVersionConstraintEvaluator {

  protected $availableOperators = array('<', 'lt', '<=', 'le', '>', 'gt', '>=', 'ge', '==', '=', 'eq', '!=', '<>', 'ne');

  /**
   * The PHP version to compare against.
   *
   * @var string
   */
  protected $phpVersion = PHP_VERSION;

  /**
   * {@inheritdoc}
   */
  public function getConstraintType() {
    return 'php-version';
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate(array $constraints) {
    /** @var \BartFeenstra\Doobie\Constraint\ConstraintInterface[] $constraints */
    foreach ($constraints as $constraint) {
      $operator = '==';
      $expected_value = $constraint->getExpectedValue();
      foreach ($this->availableOperators as $available_operator) {
        if (preg_match('#^' . $available_operator . '\d#', $expected_value)) {
          // Extract the operator from the expected value.
          $operator = $available_operator;
          $expected_value = substr($expected_value, strlen($operator));
          break;
        }
      }
      $constraint->setStatus(!version_compare($this->phpVersion, $expected_value, $operator));
      $constraint->setActualValue($this->phpVersion);
    }
  }

  /**
   * Sets the PHP version to compare against.
   *
   * @param string $php_version
   *
   * @return $this;
   */
  public function setPhpVersion($php_version) {
    $this->phpVersion = $php_version;

    return $this;
  }

}
