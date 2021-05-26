<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request;

use HnutiBrontosaurus\BisClient\UsageException;


final class Adoption implements ToArray
{

	public function __construct(
		private int $amount,
		private string $firstName,
		private string $lastName,
		private string $streetAddress,
		private string $streetNumber,
		private string $postalCode,
		private string $city,
		private string $emailAddress,
		private ?int $preferredUnitOfTypeRegional,
		private ?int $preferredUnitOfTypeBase,
		private bool $excludeFromPublic,
	) {
		throw new UsageException('This is not implemented yet.');
	}


	public function toArray(): array
	{
		return [];
	}


}
