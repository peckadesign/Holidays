<?php declare(strict_types = 1);

namespace Pd\Holidays;

use Pd;


class HolidayFacade implements IHolidayFacade
{

	/** @var array|ILocalization[] */
	private $localizations;


	public function getHoliday(string $countryCode, \DateTimeInterface $dateTime): ?IHoliday
	{
		$localization = $this->localizations[$countryCode] ?? NULL;

		if ( ! $localization) {
			return NULL;
		}

		$year = $localization->getHolidays((int) $dateTime->format('Y'));

		return $year->getHoliday($dateTime);
	}


	public function getHolidays(string $countryCode, int $year): IYear
	{
		$localization = $this->localizations[$countryCode] ?? NULL;

		if ( ! $localization) {
			return new Year([]);
		}

		return $localization->getHolidays($year);
	}


	public function addLocalization(string $countryCode, ILocalization $localization): void
	{
		$this->localizations[$countryCode] = $localization;
	}

}
