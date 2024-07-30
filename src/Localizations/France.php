<?php declare(strict_types = 1);

namespace Pd\Holidays\Localizations;

class France implements \Pd\Holidays\ILocalization
{

	/** @var array<int, \Pd\Holidays\Year> */
	private array $years;

	private \Pd\Holidays\HolidayFactory $holidayFactory;


	public function __construct(
		\Pd\Holidays\HolidayFactory $holidayFactory
	) {
		$this->holidayFactory = $holidayFactory;
	}


	public function getHolidays(int $year): \Pd\Holidays\IYear
	{
		if (isset($this->years[$year])) {
			return $this->years[$year];
		}

		$holidays[] = $this->holidayFactory->create(1, 1, '_label_holiday_01_01');
		$holidays[] = $this->holidayFactory->create(5, 1, '_label_holiday_05_01');
		$holidays[] = $this->holidayFactory->create(5, 8, '_label_holiday_05_08');
		$holidays[] = $this->holidayFactory->create(7, 14, '_label_holiday_07_14');
		$holidays[] = $this->holidayFactory->create(8, 15, '_label_holiday_08_15');
		$holidays[] = $this->holidayFactory->create(11, 1, '_label_holiday_11_01');
		$holidays[] = $this->holidayFactory->create(11, 11, '_label_holiday_11_11');
		$holidays[] = $this->holidayFactory->create(12, 25, '_label_holiday_12_25');
		$holidays[] = $this->holidayFactory->create(12, 26, '_label_holiday_12_26');

		$easter = new \DateTimeImmutable('@' . \easter_date($year));

		$holidays[] = $this->createHoliday($easter->modify('+1 day'), '_label_holiday_eastern_monday');
		$holidays[] = $this->createHoliday($easter->modify('-2 day'), '_label_holiday_eastern_friday');
		$holidays[] = $this->createHoliday($easter->modify('+39 day'), '_label_holiday_ascension');
		$holidays[] = $this->createHoliday($easter->modify('+50 day'), '_label_holiday_whit_monday');

		$this->years[$year] = new \Pd\Holidays\Year($holidays);

		return $this->years[$year];
	}


	private function createHoliday(\DateTimeInterface $dateTime, string $name): \Pd\Holidays\Holiday
	{
		return $this->holidayFactory->create((int) $dateTime->format('n'), (int) $dateTime->format('j'), $name);
	}

}
