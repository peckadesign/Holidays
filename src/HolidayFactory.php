<?php declare(strict_types = 1);

namespace Pd\Holidays;

class HolidayFactory
{

	/**
	 * @var array<string, string> ['_lang' => 'value']
	 */
	private array $translates;


	/**
	 * @param array<string, string> $translates
	 */
	public function __construct(array $translates)
	{
		$this->translates = $translates;
	}


	public function create(int $month, int $day, string $name): Holiday
	{
		return new Holiday($month, $day, $this->translates[$name] ?? $name);
	}

}
