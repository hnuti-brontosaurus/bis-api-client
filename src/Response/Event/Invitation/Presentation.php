<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Invitation;


final class Presentation
{

	/**
	 * @param Photo[] $photos
	 */
	private function __construct(
		private ?string $text,
		private array $photos = [],
	) {}


	/**
	 * @param Photo[] $photos
	 */
	public static function from(?string $text, array $photos): self
	{
		return new self($text, $photos);
	}


	public function getText(): ?string
	{
		return $this->text;
	}


	/**
	 * @return Photo[]
	 */
	public function getPhotos(): array
	{
		return $this->photos;
	}

}
