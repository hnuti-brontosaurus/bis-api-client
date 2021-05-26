<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Event;

use HnutiBrontosaurus\BisClient\Request\ToArray;


final class EventAttendee implements ToArray
{

	/**
	 * @param string[] $questionAnswers
	 */
	public function __construct(
		private int $eventId,
		private string $firstName,
		private string $lastName,
		private \DateTimeImmutable $birthDate,
		private string $phoneNumber,
		private string $emailAddress,
		private ?string $note,
		private array $questionAnswers,
	) {}


	public function toArray(): array
	{
		$questionAnswers = [];
		$i = 1;
		foreach ($this->questionAnswers as $questionAnswer) {
			$questionAnswers['additional_question_' . $i] = $questionAnswer;
			$i++;
		}

		return \array_merge([
			'event' => $this->eventId,
			'first_name' => $this->firstName,
			'last_name' => $this->lastName,
			'telephone' => $this->phoneNumber,
			'email' => $this->emailAddress,
			'age_group' => $this->birthDate->format('Y'),
			'birth_month' => $this->birthDate->format('n'),
			'birth_day' => $this->birthDate->format('j'),
			'note' => $this->note,
		], $questionAnswers);
	}

}
