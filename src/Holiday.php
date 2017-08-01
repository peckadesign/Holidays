<?php declare(strict_types = 1);

namespace Pd\Holidays;

class Holiday implements IHoliday
{

	/**
	 * @var int
	 */
	private $month;

	/**
	 * @var int
	 */
	private $day;

	/**
	 * @var string
	 */
	private $name;


	public function __construct(
		int $month,
		int $day,
		string $name
	) {
		$this->month = $month;
		$this->day = $day;
		$this->name = $name;
	}


	public function getMonth(): int
	{
		return $this->month;
	}


	public function getDay(): int
	{
		return $this->day;
	}


	public function getName(): string
	{
		return $this->name;
	}

}
