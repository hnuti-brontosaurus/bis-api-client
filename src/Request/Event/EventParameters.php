<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Event;

use HnutiBrontosaurus\BisClient\Enums\EventType;
use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Enums\TargetGroup;
use HnutiBrontosaurus\BisClient\Request\ToArray;
use HnutiBrontosaurus\BisClient\UsageException;


final class EventParameters implements ToArray
{

	private Ordering $ordering;

	public function __construct()
	{
		$this->orderByDateTo();
	}



	// filter

	const FILTER_CLUB = 1;
	const FILTER_WEEKEND = 2;
	const FILTER_CAMP = 4;
	const FILTER_EKOSTAN = 8;

	private $filter; // todo type

	/**
	 * todo
	 *
	 * This parameter serves as combinator for multiple conditions, which can not be achieved with concatenating type, program, target group or any other available parameters.
	 * For example you can not make an union among different parameters. Let's say you want all events which are of type=ohb or of program=brdo. This is not possible with API parameters.
	 * Thus you can take advantage of preset filters which are documented here: https://bis.brontosaurus.cz/myr.php
	 *
	 * Beside standard constant usage as a parameter, you can pass bitwise operation argument, e.g. `EventParameters::FILTER_WEEKEND|EventParameters::FILTER_CAMP`.
	 */
	public function setFilter(int $filter): self
	{
		$keys = [
			self::FILTER_CLUB => 'klub',
			self::FILTER_WEEKEND => 'vik',
			self::FILTER_CAMP => 'tabor',
			self::FILTER_EKOSTAN => 'ekostan',
		];

		$param = match ($filter) {
			self::FILTER_CLUB, self::FILTER_WEEKEND, self::FILTER_CAMP, self::FILTER_EKOSTAN => $keys[$filter],
			self::FILTER_WEEKEND | self::FILTER_CAMP => $keys[self::FILTER_WEEKEND] . $keys[self::FILTER_CAMP],
			self::FILTER_WEEKEND | self::FILTER_EKOSTAN => $keys[self::FILTER_WEEKEND] . $keys[self::FILTER_EKOSTAN],
			default => throw new UsageException('Value `' . $filter . '` is not of valid types and their combinations for `filter` parameter. Only `weekend+camp` and `weekend+ekostan` can be combined.'),
		};

		$this->filter = $param; // todo add to toArray()
		return $this;
	}


	// type

	/** @var EventType[] */
	private array $types = [];

	public function setType(EventType $type): self
	{
		$this->types = [$type];
		return $this;
	}

	/**
	 * @param EventType[] $types
	 */
	public function setTypes(array $types): self
	{
		$this->types = $types;
		return $this;
	}


	// program

	/** @var Program[] */
	private array $programs = [];

	public function setProgram(Program $program): self
	{
		$this->programs = [$program];
		return $this;
	}

	/**
	 * @param Program[] $programs
	 */
	public function setPrograms(array $programs): self
	{
		$this->programs = $programs;
		return $this;
	}


	// target group

	/** @var TargetGroup[] */
	private array $targetGroups = [];

	public function setTargetGroup(TargetGroup $targetGroup): self
	{
		$this->targetGroups = [$targetGroup];
		return $this;
	}

	/**
	 * @param TargetGroup[] $targetGroups
	 */
	public function setTargetGroups(array $targetGroups): self
	{
		$this->targetGroups = $targetGroups;
		return $this;
	}



	// miscellaneous

	private \DateTimeImmutable $dateFromGreaterThan;

	/**
	 * Excludes events which are running (started, but not yet ended). Defaults to include them.
	 */
	public function excludeRunning(): self
	{
		$this->dateFromGreaterThan = new \DateTimeImmutable();
		return $this;
	}


	public function orderByDateFrom(): self
	{
		$this->ordering = Ordering::DATE_FROM();
		return $this;
	}

	public function orderByDateTo(): self
	{
		$this->ordering = Ordering::DATE_TO();
		return $this;
	}


	/** @var int[] */
	private array $organizedBy = [];

	/**
	 * @param int|int[] $unitIds
	 */
	public function setOrganizedBy(array|int $unitIds): self
	{
		// If just single value, wrap it into an array.
		if ( ! \is_array($unitIds)) {
			$this->organizedBy = [$unitIds];
			return $this;
		}

		$this->organizedBy = $unitIds;
		return $this;
	}



	// getters

	public function toArray(): array
	{
		$array = [
			'event_type_array' => \implode(',', $this->types),
			'program_array' => \implode(',', $this->programs),
			'indended_for_array' => \implode(',', $this->targetGroups),
			'ordering' => $this->ordering,
			'administrative_unit' => \implode(',', $this->organizedBy),
		];

		if (isset($this->dateFromGreaterThan)) {
			$array['date_from__gte'] = $this->dateFromGreaterThan->format('Y-m-d');
		}

		return $array;
	}

}
