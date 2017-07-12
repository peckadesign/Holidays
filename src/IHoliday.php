<?php declare(strict_types = 1);

namespace Pd\Holidays;

interface IHoliday
{

	public function getMonth(): int;


	public function getDay(): int;


	public function getName(): string;

}
