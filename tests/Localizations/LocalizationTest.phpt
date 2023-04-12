<?php declare(strict_types = 1);

namespace PdTests\Holidays\Localizations;

use Pd;
use Tester;


require __DIR__ . '/../bootstrap.php';


/**
 * TEST: Oveření funkčnosti definovaných sad svátků
 *
 * @testCase
 */
class LocalizationTest extends Tester\TestCase
{

	public function getTestHolidaysData()
	{
		$holidayFactory = new Pd\Holidays\HolidayFactory([]);

		$data = [
			[new Pd\Holidays\Localizations\Czech($holidayFactory), 2016, 12],
			[new Pd\Holidays\Localizations\Czech($holidayFactory), 2017, 13],
			[new Pd\Holidays\Localizations\Czech($holidayFactory), 2018, 13],
			[new Pd\Holidays\Localizations\Slovak($holidayFactory), 2016, 15],
			[new Pd\Holidays\Localizations\Slovak($holidayFactory), 2017, 15],
			[new Pd\Holidays\Localizations\Slovak($holidayFactory), 2018, 15],
			[new Pd\Holidays\Localizations\Slovak($holidayFactory), 2023, 15],
			[new Pd\Holidays\Localizations\Slovak($holidayFactory), 2025, 15],
		];

		return $data;
	}


	/**
	 * @dataProvider getTestHolidaysData
	 */
	public function testHolidays(Pd\Holidays\ILocalization $localization, int $year, int $numberOfHolidays)
	{
		$year = $localization->getHolidays($year);

		Tester\Assert::notEqual(NULL, $year);

		Tester\Assert::count($numberOfHolidays, $year->getHolidays());
	}
}


(new LocalizationTest())->run();
