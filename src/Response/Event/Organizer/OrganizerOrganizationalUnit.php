<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Organizer;


final class OrganizerOrganizationalUnit
{

	private function __construct(
		private string $name,
		private ?string $website,
	) {}


	public static function from(string $name, ?string $website): self
	{
		return new self($name, $website);
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getWebsite(): ?string
	{
		return $this->website;
	}

}
