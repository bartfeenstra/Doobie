<?php

/**
 * @file
 * Contains \BartFeenstra\Doobie\FileFinder\FileFinderInterface.
 */

namespace BartFeenstra\Doobie\FileFinder;

/**
 * Finds PHP files to scan for to-do markers.
 */
class PhpFileFinder implements FileFinderInterface {

  /**
   * The directory to scan for files in.
   *
   * @var string
   */
  protected $directory;

  /**
   * The extension of the files to find.
   *
   * @var string
   */
  protected $extension;

  /**
   * Constructs a new class instance.
   *
   * @param string $directory
   * @param string $extension
   */
  public function __construct($directory, $extension) {
    $this->directory = $directory;
    $this->extension = $extension;
  }

  /**
   * Gets the names of the files to scan.
   *
   * @return string[]
   *   An indexed array with absolute file paths.
   */
  public function getFileNames() {
    $directory = new \RecursiveDirectoryIterator($this->directory);
    $iterator = new \RecursiveIteratorIterator($directory);
    $regex = new \RegexIterator($iterator, '/^.+\.' . $this->extension . '$/i', \RecursiveRegexIterator::GET_MATCH);
    $file_names = array();
    foreach ($regex as $thing) {
      $file_names[] = $thing[0];
    }

    return $file_names;
  }

}
