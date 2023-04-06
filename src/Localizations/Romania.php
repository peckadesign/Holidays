<?php declare(strict_types = 1);

namespace Pd\Holidays\Localizations;

class Romania implements \Pd\Holidays\ILocalization
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
		$holidays[] = $this->holidayFactory->create(1, 2, '_label_holiday_01_02');
		$holidays[] = $this->holidayFactory->create(1, 24, '_label_holiday_01_24');
		$holidays[] = $this->holidayFactory->create(5, 1, '_label_holiday_05_01');
		$holidays[] = $this->holidayFactory->create(6, 1, '_label_holiday_06_01');
		$holidays[] = $this->holidayFactory->create(8, 15, '_label_holiday_08_15');
		$holidays[] = $this->holidayFactory->create(11, 30, '_label_holiday_11_30');
		$holidays[] = $this->holidayFactory->create(12, 1, '_label_holiday_12_01');
		$holidays[] = $this->holidayFactory->create(12, 25, '_label_holiday_12_25');
		$holidays[] = $this->holidayFactory->create(12, 26, '_label_holiday_12_26');

		// velikonoční neděle
		$easterDateInJulianCalendar = \DateTimeImmutable::createFromFormat('U', (string) \easter_date($year, \CAL_EASTER_ALWAYS_JULIAN));
		if ($easterDateInJulianCalendar === FALSE) {
			throw new \Exception('Invalid easter date');
		}
		$julianDays = \cal_to_jd(
			\CAL_JULIAN,
			(int) $easterDateInJulianCalendar->format('m'),
			(int) $easterDateInJulianCalendar->format('d'),
			(int) $easterDateInJulianCalendar->format('Y')
		);
		$easterDateInGregorianCalendar = \DateTimeImmutable::createFromFormat('U', (string) \jdtounix($julianDays));
		if ($easterDateInGregorianCalendar === FALSE) {
			throw new \Exception('Invalid easter date');
		}

		// velikonoce
		$holidays[] = $this->createHoliday($easterDateInGregorianCalendar->modify('-2 day'), '_label_holiday_eastern_friday');
		$holidays[] = $this->createHoliday($easterDateInGregorianCalendar, '_label_holiday_eastern_sunday');
		$holidays[] = $this->createHoliday($easterDateInGregorianCalendar->modify('+1 day'), '_label_holiday_eastern_monday');

		// letnice
		$holidays[] = $this->createHoliday($easterDateInGregorianCalendar->modify('+49 day'), '_label_holiday_pentecost');
		$holidays[] = $this->createHoliday($easterDateInGregorianCalendar->modify('+50 day'), '_label_holiday_pentecost2');

		$this->years[$year] = new \Pd\Holidays\Year($holidays);

		return $this->years[$year];
	}


	private function createHoliday(\DateTimeInterface $dateTime, string $name): \Pd\Holidays\Holiday
	{
		return $this->holidayFactory->create((int) $dateTime->format('n'), (int) $dateTime->format('j'), $name);
	}

}
