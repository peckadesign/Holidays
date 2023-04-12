<?php declare(strict_types = 1);

namespace Pd\Holidays\DI;

final class Extension extends \Nette\DI\CompilerExtension
{

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$builder = $this->getContainerBuilder();

		/** @var \Nette\DI\Definitions\ServiceDefinition $holidayFacade */
		$holidayFacade = $builder
			->addDefinition($this->prefix('holidayFacade'))
			->setFactory(\Pd\Holidays\HolidayFacade::class)
		;

		$this->addLocalization($holidayFacade, \Pd\Holidays\Localizations\Czech::class, \Pd\Holidays\Localizations\ICzech::COUNTRY_CODE_CZECH);
		$this->addLocalization($holidayFacade, \Pd\Holidays\Localizations\Slovak::class, \Pd\Holidays\Localizations\ISlovak::COUNTRY_CODE_SLOVAK);
		$this->addLocalization($holidayFacade, \Pd\Holidays\Localizations\Romania::class, \Pd\Holidays\Localizations\IRomania::COUNTRY_CODE_ROMANIA);
	}


	private function addLocalization(\Nette\DI\Definitions\ServiceDefinition $holidayFacade, string $localizationClass, string $countryCode): void
	{
		$builder = $this->getContainerBuilder();
		$countryCodePrefix = \Nette\Utils\Strings::lower($countryCode);

		$translations = \Nette\Neon\Neon::decode((string) \file_get_contents(__DIR__ . '/../Localizations/' . \Nette\Utils\Strings::lower(\Nette\Utils\Strings::substring($localizationClass, \strrpos($localizationClass, '\\') + 1)) . '.neon'));

		$holidayFactory = $builder
			->addDefinition($this->prefix($countryCodePrefix . 'HolidayFactory'))
			->setFactory(\Pd\Holidays\HolidayFactory::class, [$translations])
			->setAutowired(FALSE)
		;

		$localization = $builder
			->addDefinition($this->prefix($countryCodePrefix))
			->setFactory($localizationClass, [$holidayFactory])
			->setAutowired(FALSE)
		;

		$holidayFacade
			->addSetup('addLocalization', [$countryCode, $localization]);
	}

}
