<?php declare(strict_types = 1);

namespace Pd\Holidays;

interface ILocalization
{

	public function getHolidays(int $year): IYear;

}
