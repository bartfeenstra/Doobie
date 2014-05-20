<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Constraint\Constraint.
 */

namespace BartFeenstra\Doobie\Constraint;

/**
 * Provides a constraint.
 */
class Constraint implements ConstraintInterface {

  /**
   * The expected constraint value.
   *
   * @var string
   */
  protected $expectedValue;

  /**
   * The actual constraint value.
   *
   * @var string
   */
  protected $actualValue;

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
   * The constraint status.
   *
   * @var bool
   *   TRUE if the constraint matches, FALSE if it no longer does.
   */
  protected $status;

  /**
   * The constraint type.
   *
   * @var string
   */
  protected $type;

  /**
   * Constructs a new class instance.
   *
   * @param string $type
   *   The constraint type.
   * @param mixed $expected_value
   *   The expected constraint value.
   * @param string $file_name
   *   The name of the file the constraint is defined in.
   * @param int $line_number
   *   The number of the line the constraint is defined on.
   */
  public function __construct($type, $expected_value, $file_name, $line_number) {
    $this->expectedValue = $expected_value;
    $this->fileName = $file_name;
    $this->lineNumber = $line_number;
    $this->type = $type;
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->type;
  }

  /**
   * {@inheritdoc}
   */
  public function getExpectedValue() {
    return $this->expectedValue;
  }

  /**
   * {@inheritdoc}
   */
  public function getActualValue() {
    return $this->actualValue;
  }

  /**
   * {@inheritdoc}
   */
  public function setActualValue($value) {
    $this->actualValue = $value;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus($status) {
    $this->status = $status;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatus() {
    return $this->status;
  }

  /**
   * {@inheritdoc}
   */
  public function getFileName() {
    return $this->fileName;
  }

  /**
   * {@inheritdoc}
   */
  public function getLineNumber() {
    return $this->lineNumber;
  }

}
