<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Registration;

use HnutiBrontosaurus\BisClient\RuntimeException;
use HnutiBrontosaurus\BisClient\UsageException;


final class RegistrationType
{

	/**
	 * @param RegistrationQuestion[] $questions
	 */
	private function __construct(
		private RegistrationTypeEnum $type,
		private array $questions, // in case of registering via Brontoweb
		private ?string $email, // in case of registering via e-mail
		private ?string $url, // in case of registering via custom webpage
	) {}

	/**
	 * @param RegistrationQuestion[] $questions
	 */
	public static function from(
		RegistrationTypeEnum $type,
		array $questions,
		?string $email,
		?string $url,
	): self
	{
		return new self($type, $questions, $email, $url);
	}


	// registration via Brontoweb

	public function isOfTypeBrontoWeb(): bool
	{
		return $this->type->equals(RegistrationTypeEnum::BRONTOWEB());
	}


	/**
	 * @return RegistrationQuestion[]
	 */
	public function getQuestions(): array
	{
		return $this->questions;
	}


	// registration via e-mail

	public function isOfTypeEmail(): bool
	{
		return $this->type->equals(RegistrationTypeEnum::EMAIL());
	}

	public function getEmail(): ?string
	{
		if ( ! $this->isOfTypeEmail()) {
			throw new UsageException('This method can not be called when the registration is not of `via e-mail` type.');
		}

		if ($this->email === null) {
			/*
			 * Ideally, this should not happen, but we can not rely on it. If it happens, we want to know about it ->
			 * assert() is not enough. We can just log it, but that would lead user into clicking a button which does nothing.
			 * Thus rendering error page covers both – logging and preventing user from accessing non-working page.
			 */
			throw new RuntimeException('E-mail must not be null in case of registration via e-mail.');
		}

		return $this->email;
	}


	// registration via custom webpage

	public function isOfTypeCustomWebpage(): bool
	{
		return $this->type->equals(RegistrationTypeEnum::EXTERNAL_WEBPAGE());
	}

	public function getUrl(): ?string
	{
		if ( ! $this->isOfTypeCustomWebpage()) {
			throw new UsageException('This method can not be called when the registration is not of `via custom webpage` type.');
		}

		if ($this->url === null) {
			/*
			 * Ideally, this should not happen, but we can not rely on it. If it happens, we want to know about it ->
			 * assert() is not enough. We can just log it, but that would lead user into clicking a button which does nothing.
			 * Thus rendering error page covers both – logging and preventing user from accessing non-working page.
			 */
			throw new RuntimeException('URL must not be null in case of registration via custom webpage.');
		}

		return $this->url;
	}


	// no registration needed

	public function isOfTypeNone(): bool
	{
		return $this->type->equals(RegistrationTypeEnum::NONE());
	}


	// registration disabled

	public function isOfTypeDisabled(): bool
	{
		return $this->type->equals(RegistrationTypeEnum::DISABLED());
	}

}
