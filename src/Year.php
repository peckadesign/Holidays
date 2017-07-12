<?php declare(strict_types = 1);

namespace Pd\Holidays;

class Year implements IYear
{

	/** @var array */
	private $holidaysStructured = [];

	/** @var array|IHoliday[] */
	private $holidays = [];


	public function __construct(
		array $holidays
	) {
		$this->holidays = $holidays;

		foreach ($holidays as $holiday) {
			$this->holidaysStructured[$holiday->getMonth()][$holiday->getDay()] = $holiday;
		}
	}


	public function getHoliday(\DateTimeInterface $dateTime): ?IHoliday
	{
		return $this->holidaysStructured[$dateTime->format('n')][$dateTime->format('j')] ?? NULL;
	}


	/**
	 * @return array|IHoliday[]
	 */
	public function getHolidays(): array
	{
		return $this->holidays;
	}
}
