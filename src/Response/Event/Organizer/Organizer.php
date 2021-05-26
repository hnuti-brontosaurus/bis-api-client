<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Organizer;


final class Organizer
{

	private function __construct(
		private ?OrganizerOrganizationalUnit $organizationalUnit,
		private ?string $responsiblePerson,
		private ?string $organizers,
		private ContactPerson $contactPerson,
	) {}


	public static function from(
		?OrganizerOrganizationalUnit $organizationalUnit,
		?string $responsiblePerson,
		?string $organizers,
		ContactPerson $contactPerson,
	): self
	{
		return new self(
			$organizationalUnit,
			$responsiblePerson,
			$organizers,
			$contactPerson,
		);
	}


	public function getOrganizationalUnit(): ?OrganizerOrganizationalUnit
	{
		return $this->organizationalUnit;
	}


	public function getResponsiblePerson(): ?string
	{
		return $this->responsiblePerson;
	}


	public function getOrganizers(): ?string
	{
		return $this->organizers;
	}


	public function getContactPerson(): ContactPerson
	{
		return $this->contactPerson;
	}

}
