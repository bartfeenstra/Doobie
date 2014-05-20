<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Parser\ParserInterface.
 */

namespace BartFeenstra\Doobie\Parser;

/**
 * Defines a file parser.
 */
interface ParserInterface {

  /**
   * Parses a file and returns constraints.
   *
   * @param string[] $file_names
   *   The absolute names of the files to parse.
   *
   * @return \BartFeenstra\Doobie\Constraint\ConstraintInterface[]
   */
  public function parse (array $file_names);

}
