<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Organizer;

final class ContactPerson
{

	private function __construct(
		private string $name,
		private string $emailAddress,
		private string $phoneNumber,
	)
	{}


	public static function from(
		string $name,
		string $emailAddress,
		string $phoneNumber,
	): self
	{
		return new self($name, $emailAddress, $phoneNumber);
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getEmailAddress(): string
	{
		return $this->emailAddress;
	}


	public function getPhoneNumber(): string
	{
		return $this->phoneNumber;
	}

}
