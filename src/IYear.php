<?php declare(strict_types = 1);

namespace Pd\Holidays;

interface IYear
{

	public function getHoliday(\DateTimeInterface $dateTime): ?IHoliday;


	/** @return array|IHoliday[] */
	public function getHolidays(): array;

}
