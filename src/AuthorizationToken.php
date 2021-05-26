<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;


final class AuthorizationToken
{

	private function __construct(
		private string $value,
	) {}

	public static function from(string $value): self
	{
		return new self($value);
	}

	public function toString(): string
	{
		return $this->value;
	}

	public function __toString(): string
	{
		return $this->toString();
	}

}
