<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\OrganizationalUnit;

use HnutiBrontosaurus\BisClient\Response\Coordinates;


final class OrganizationalUnit
{

	private function __construct(
		private int $id,
		private string $name,
		private string $street,
		private string $city,
		private string $postCode,
		private ?Coordinates $coordinates,
		private string $phone,
		private string $email,
		private ?string $website,
		private OrganizationalUnitType $type,
		private string $chairman,
		private string $manager,
	) {}


	public static function fromResponseData(\stdClass $data): self
	{
		return new self(
			$data->id,
			$data->name,
			$data->street,
			$data->city,
			$data->zip_code,
			$data->gps_latitude !== null && $data->gps_longitude !== null
				? Coordinates::from($data->gps_latitude, $data->gps_longitude)
				: null,
			$data->telephone,
			$data->from_email_address,
			$data->web_url,
			OrganizationalUnitType::fromScalar($data->level),
			$data->president_name,
			$data->manager_name,
		);
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getStreet(): string
	{
		return $this->street;
	}


	public function getCity(): string
	{
		return $this->city;
	}


	public function getPostCode(): string
	{
		return $this->postCode;
	}


	public function getCoordinates(): ?Coordinates
	{
		return $this->coordinates;
	}


	public function getPhone(): string
	{
		return $this->phone;
	}


	public function getEmail(): string
	{
		return $this->email;
	}


	public function getWebsite(): ?string
	{
		return $this->website;
	}


	public function getChairman(): string
	{
		return $this->chairman;
	}


	public function getManager(): string
	{
		return $this->manager;
	}


	public function isClub(): bool
	{
		return $this->type->equals(OrganizationalUnitType::CLUB());
	}


	public function isBaseUnit(): bool
	{
		return $this->type->equals(OrganizationalUnitType::BASE());
	}


	public function isRegionalUnit(): bool
	{
		return $this->type->equals(OrganizationalUnitType::REGIONAL());
	}


	public function isOffice(): bool
	{
		return $this->type->equals(OrganizationalUnitType::OFFICE());
	}

}
