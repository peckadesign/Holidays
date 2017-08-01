<?php declare(strict_types = 1);

namespace Pd\Holidays\Localizations;

use Pd;
use Nette;


class Slovak implements Pd\Holidays\ILocalization
{

	/** @var array */
	private $years;

	/**
	 * @var Pd\Holidays\HolidayFactory
	 */
	private $holidayFactory;


	public function __construct(
		Pd\Holidays\HolidayFactory $holidayFactory
	) {

		$this->holidayFactory = $holidayFactory;
	}


	public function getHolidays(int $year): Pd\Holidays\IYear
	{
		if (isset($this->years[$year])) {
			return $this->years[$year];
		}

		$holidays[] = $this->holidayFactory->create(1, 1, '_label_holiday_01_01');
		$holidays[] = $this->holidayFactory->create(1, 6, '_label_holiday_06_01');
		$holidays[] = $this->holidayFactory->create(5, 1, '_label_holiday_01_05');
		$holidays[] = $this->holidayFactory->create(5, 8, '_label_holiday_08_05');
		$holidays[] = $this->holidayFactory->create(7, 5, '_label_holiday_05_07');
		$holidays[] = $this->holidayFactory->create(8, 29, '_label_holiday_29_08');
		$holidays[] = $this->holidayFactory->create(9, 1, '_label_holiday_01_09');
		$holidays[] = $this->holidayFactory->create(9, 15, '_label_holiday_15_09');
		$holidays[] = $this->holidayFactory->create(11, 1, '_label_holiday_01_11');
		$holidays[] = $this->holidayFactory->create(11, 17, '_label_holiday_17_11');
		$holidays[] = $this->holidayFactory->create(12, 24, '_label_holiday_24_12');
		$holidays[] = $this->holidayFactory->create(12, 25, '_label_holiday_25_12');
		$holidays[] = $this->holidayFactory->create(12, 26, '_label_holiday_26_12');

		$eastern = Nette\Utils\DateTime::from(strtotime('+ 1 day', easter_date($year)));
		$holidays[] = $this->createHoliday($eastern, '_label_holiday_eastern');

		$easternFriday = Nette\Utils\DateTime::from(strtotime('- 2 day', easter_date($year)));
		$holidays[] = $this->createHoliday($easternFriday, '_label_holiday_eastern_friday');

		$this->years[$year] = new Pd\Holidays\Year($holidays);

		return $this->years[$year];
	}


	private function createHoliday(\DateTimeInterface $dateTime, string $name)
	{
		return $this->holidayFactory->create((int) $dateTime->format('n'), (int) $dateTime->format('j'), $name);
	}
}
