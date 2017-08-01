<?php

namespace PdTests\Holidays\Year;

use Pd;
use Tester;


require __DIR__ . '/../bootstrap.php';


/**
 * TEST: Oveření funkčnosti jedhono roku svátků
 *
 * @testCase
 */
class YearTest extends Tester\TestCase
{

	public function testIsHoliday()
	{
		$testHoliday1 = new Pd\Holidays\Holiday(10, 1, 'svatek');
		$testHoliday2 = new Pd\Holidays\Holiday(10, 5, 'svatek 2');

		$year = new Pd\Holidays\Year([$testHoliday1, $testHoliday2]);

		$holiday = $year->getHoliday(new \DateTimeImmutable(date('Y-10-01')));
		Tester\Assert::notEqual(NULL, $holiday);
		Tester\Assert::equal('svatek', $holiday->getName());

		$holiday = $year->getHoliday(new \DateTimeImmutable(date('Y-10-05')));
		Tester\Assert::notEqual(NULL, $holiday);
		Tester\Assert::equal('svatek 2', $holiday->getName());

		$holiday = $year->getHoliday(new \DateTimeImmutable(date('Y-10-06')));
		Tester\Assert::null($holiday);

		$holidays = $year->getHolidays();
		Tester\Assert::count(2, $holidays);

		foreach ($holidays as $holiday) {
			Tester\Assert::true($holiday instanceof Pd\Holidays\IHoliday);
		}
	}

}


(new YearTest())->run();
