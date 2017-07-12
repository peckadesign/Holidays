<?php declare(strict_types = 1);

namespace PdTests\Holidays\HolidayFacade;

use Pd;
use Tester;


require __DIR__ . '/../bootstrap.php';


/**
 * TEST: Oveření funkčnosti fasády pro práci se svátky
 *
 * @testCase
 */
class HolidayFacadeTest extends Tester\TestCase
{

	public function testEmptyYear()
	{
		$holidayFacade = new Pd\Holidays\HolidayFacade();

		$localization = $this->getEmptyLocalization();

		$holidayFacade->addLocalization('CZ', $localization);
		$year = $holidayFacade->getHolidays('CZ', (int) date('Y'));
		Tester\Assert::count(0, $year->getHolidays());
	}


	public function testYearWithHolidays()
	{
		$holidayFacade = new Pd\Holidays\HolidayFacade();

		$localization = new class implements Pd\Holidays\ILocalization
		{

			public function getHolidays(int $year): Pd\Holidays\IYear
			{
				$holidays = [
					new Pd\Holidays\Holiday(10, 1, 'svatek 1'),
					new Pd\Holidays\Holiday(10, 1, 'svatek 2'),
					new Pd\Holidays\Holiday(10, 1, 'svatek 3'),
				];
				$year = new Pd\Holidays\Year($holidays);

				return $year;
			}
		};

		$holidayFacade->addLocalization('CZ', $localization);
		$year = $holidayFacade->getHolidays('CZ', (int) date('Y'));
		Tester\Assert::count(3, $year->getHolidays());

		$year = $holidayFacade->getHolidays('SK', (int) date('Y'));
		Tester\Assert::count(0, $year->getHolidays());

		$holidayFacade->addLocalization('SK', $this->getEmptyLocalization());
		$year = $holidayFacade->getHolidays('SK', (int) date('Y'));
		Tester\Assert::count(0, $year->getHolidays());
		$year = $holidayFacade->getHolidays('CZ', (int) date('Y'));
		Tester\Assert::count(3, $year->getHolidays());
	}


	private function getEmptyLocalization(): Pd\Holidays\ILocalization
	{
		$localization = new class implements Pd\Holidays\ILocalization
		{

			public function getHolidays(int $year): Pd\Holidays\IYear
			{
				$year = new Pd\Holidays\Year([]);

				return $year;
			}
		};

		return $localization;
	}
}


(new HolidayFacadeTest())->run();
