<?php declare(strict_types = 1);

namespace Pd\Holidays\DI;

use Nette;
use Pd;


final class Extension extends Nette\DI\CompilerExtension
{

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$builder = $this->getContainerBuilder();

		$holidayFacade = $builder
			->addDefinition($this->prefix('holidayFacade'))
			->setFactory(Pd\Holidays\HolidayFacade::class)
		;

		$this->addLocalization($holidayFacade, Pd\Holidays\Localizations\Czech::class, Pd\Holidays\Localizations\ICzech::COUNTRY_CODE_CZECH);
		$this->addLocalization($holidayFacade, Pd\Holidays\Localizations\Slovak::class, Pd\Holidays\Localizations\ISlovak::COUNTRY_CODE_SLOVAK);
	}


	private function addLocalization(Nette\DI\ServiceDefinition $holidayFacade, string $localizationClass, string $countryCode): void
	{
		$builder = $this->getContainerBuilder();
		$countryCodePrefix = Nette\Utils\Strings::lower($countryCode);

		$translations = Nette\Neon\Neon::decode((string) \file_get_contents(__DIR__ . '/../Localizations/' . Nette\Utils\Strings::lower(Nette\Utils\Strings::substring($localizationClass, strrpos($localizationClass, '\\') + 1)) . '.neon'));

		$czechHolidayFactory = $builder
			->addDefinition($this->prefix($countryCodePrefix . 'HolidayFactory'))
			->setFactory(Pd\Holidays\HolidayFactory::class, [$translations])
			->setAutowired(FALSE)
		;

		$localization = $builder
			->addDefinition($this->prefix($countryCodePrefix))
			->setFactory($localizationClass, [$czechHolidayFactory])
			->setAutowired(FALSE)
		;

		$holidayFacade
			->addSetup('addLocalization', [$countryCode, $localization]);
	}

}
