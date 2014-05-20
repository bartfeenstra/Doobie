# Doobie

[![Build Status](https://travis-ci.org/bartfeenstra/Doobie.png?branch=master)](https://travis-ci.org/bartfeenstra/Dobie)
[![Coverage Status](https://coveralls.io/repos/bartfeenstra/Doobie/badge.png?branch=master)](https://coveralls.io/r/bartfeenstra/Doobie?branch=master)
[![Latest Stable Version](https://poser.pugx.org/bartfeenstra/Doobie/v/stable.png)](https://packagist.org/packages/bartfeenstra/Doobie)

Doobie (*"do by"*) allows `@todo` annotations to be extended with metadata to specify
by which event the described action must have been taken.

Doobie was inspired by [andyw8/do_by](https://github.com/andyw8/do_by), which is
specific to Ruby.

# Usage

Any `@todo` annotation can contain a Doobie marker that is formatted like
`[doobie:type:expected_value]`, where `type` is the type of constraint
that must be checked (such as `php-version` or `datetime`), and
`expected_value` is the value the constraint type must have for the marker to
become expired.

## php-version

This built-in constraint type compares the expected and actual PHP versions. Use
like `[doobie:php-version:>=5.5]`.

## datetime

This built-in constraint type compares the expected and actual dates and times.
Use like `[doobie:datetime:2014-05-20 00:00 +0]`

## PHPUnit

In order to test all markers through PHPUnit, write a test case that
instantiates one or more file finders
(`\BartFeenstra\Doobie\FileFinder\FileFinderInterface`), parsers
(`\BartFeenstra\Doobie\Parser\ParserInterface`), and constraint evaluators
(`\BartFeenstra\Doobie\Constraint\ConstriantEvaluatorInterface`). The test case
can then use
`\BartFeenstra\Doobie\PhpUnit\AssertTrait` and `$this->assertDoobieMarkers($file_finders, $parsers, $constraint_evaluators)`
to trigger test failures for expires markers.