<?php declare(strict_types = 1);

namespace Pd\Holidays;

interface IHolidayFacade
{

	public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?IHoliday;

	public function getHolidays(string $countryCode, int $year): IYear;

}
