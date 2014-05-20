<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\FileFinder\FileFinderInterface.
 */

namespace BartFeenstra\Doobie\FileFinder;

/**
 * Defines a file finder.
 *
 * File finders find the files that must be scanned for to-do markers.
 */
interface FileFinderInterface {

  /**
   * Gets the names of the files to scan.
   *
   * @return string[]
   *   An indexed array with absolute file paths.
   */
  public function getFileNames();

}
