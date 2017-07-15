<?php declare(strict_types = 1);

namespace PdTests\DI\Extension;

use Nette;
use Pd;
use Tester;


require __DIR__ . '/../../bootstrap.php';


/**
 * @testCase
 */
class ExtensionTest extends Tester\TestCase
{

	public function testExtension()
	{
		$extension = new Pd\Holidays\DI\Extension();

		$compiler = new Nette\DI\Compiler();
		$compiler->addExtension('test', $extension);

		$container = createContainer($compiler);
		/** @var Pd\Holidays\IHolidayFacade $holidayFacade */
		$holidayFacade = $container->getByType(Pd\Holidays\IHolidayFacade::class);

		Tester\Assert::true($holidayFacade instanceof Pd\Holidays\HolidayFacade);

		$czechYear = $holidayFacade->getHolidays(Pd\Holidays\Localizations\ICzech::COUNTRY_CODE_CZECH, (int) date('Y'));
		Tester\Assert::notEqual(0, count($czechYear->getHolidays()));

		$newYear = $czechYear->getHoliday(new \DateTimeImmutable('2017-01-01'));
		Tester\Assert::equal('Nový rok', $newYear->getName());

		$slovakYear = $holidayFacade->getHolidays(Pd\Holidays\Localizations\ISlovak::COUNTRY_CODE_SLOVAK, (int) date('Y'));
		Tester\Assert::notEqual(0, count($slovakYear->getHolidays()));

		$newYear = $slovakYear->getHoliday(new \DateTimeImmutable('2017-01-01'));
		Tester\Assert::equal('Deň vzniku Slovenskej republiky', $newYear->getName());
	}
}


(new ExtensionTest())->run();
