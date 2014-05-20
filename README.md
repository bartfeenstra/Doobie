# Doobie

Doobie (do-by) allows @todo annotations to be extended with metadata to specify
by which event the described action must have been taken.

# Usage

Any @todo annotation can contain a Doobie marker that is formatted like
[doobie:**type**:**expected value**], where **type** is the type of constraint
that must be checked (such as *php-version* or *datetime*), and
**expected_value** is the value the constraint type must have for the marker to
become expired.

## php-version

This built-in constraint type compares the expected and actual PHP versions. Use
like [doobie:php-version:>=5.5].

## datetime

This built-in constraint type compares the expected and actual dates and times.
Use like [doobie:datetime:2014-05-20 OO:OO +0]

## PHPUnit

In order to test all markers through PHPUnit, write a test case that
instantiates one or more file finders
(\BartFeenstra\Doobie\FileFinder\FileFinderInterface), parsers
(\BartFeenstra\Doobie\Parser\ParserInterface), and constraint evaluators
(\BartFeenstra\Doobie\Constraint\ConstriantEvaluatorInterface). The test case
can then use
\BartFeenstra\Doobie\PhpUnit\AssertTrait and $this->assertDoobieMarkers($file_finders, $parsers, $constraint_evaluators)
to trigger test failures for expires markers.