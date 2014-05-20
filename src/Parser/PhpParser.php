<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\Parser\PhpParser.
 */

namespace BartFeenstra\Doobie\Parser;
use BartFeenstra\Doobie\Constraint\Constraint;

/**
 * Parses PHP files and retrieves constraints.
 */
class PhpParser implements ParserInterface {

  /**
   * {@inheritdoc}
   */
  public function parse(array $file_names) {
    $constraints = array();
    foreach ($file_names as $file_name) {
      $tokens = token_get_all(file_get_contents($file_name));
      foreach($tokens as $token) {
        if (is_array($token) && ($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT)) {
          $line_number_token_in_file = $token[2];
          $lines = preg_split('#\n#', $token[1]);
          foreach ($lines as $line_number_line_of_token => $line) {
            $pos = strpos($line, '@todo');
            if ($pos !== FALSE) {
              $matches = array();
              preg_match_all('#\[doobie:(.+?):(.+?)\]#', $line, $matches, PREG_SET_ORDER);
              foreach ($matches as $match) {
                $constraints[] = new Constraint($match[1], $match[2], $file_name, $line_number_token_in_file + $line_number_line_of_token);
              }
            }
          }
        }
      }
    }

    return $constraints;
  }

}
