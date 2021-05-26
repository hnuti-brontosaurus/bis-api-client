<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event;

use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Enums\TargetGroup;
use HnutiBrontosaurus\BisClient\Response\Coordinates;
use HnutiBrontosaurus\BisClient\Response\Event\Invitation\Food;
use HnutiBrontosaurus\BisClient\Response\Event\Invitation\Invitation;
use HnutiBrontosaurus\BisClient\Response\Event\Invitation\Photo;
use HnutiBrontosaurus\BisClient\Response\Event\Invitation\Presentation;
use HnutiBrontosaurus\BisClient\Response\Event\Organizer\ContactPerson;
use HnutiBrontosaurus\BisClient\Response\Event\Organizer\Organizer;
use HnutiBrontosaurus\BisClient\Response\Event\Organizer\OrganizerOrganizationalUnit;
use HnutiBrontosaurus\BisClient\Response\Event\Registration\RegistrationQuestion;
use HnutiBrontosaurus\BisClient\Response\Event\Registration\RegistrationType;
use HnutiBrontosaurus\BisClient\Response\Event\Registration\RegistrationTypeEnum;


final class Event
{

	private function __construct(
		private int $id,
		private string $name,
		private ?string $coverPhotoPath,
		private \DateTimeImmutable $dateFrom,
		private \DateTimeImmutable $dateUntil,
		private Program $program,
		private Place $place,
		private RegistrationType $registrationType,
		private ?int $ageFrom,
		private ?int $ageUntil,
		private ?string $price, // single number or interval
		private Organizer $organizer,
		private TargetGroup $targetGroup,
		private Invitation $invitation,
		private \DateTimeImmutable $startDate,
		private ?string $relatedWebsite,
	) {}


	public static function fromResponseData(\stdClass $data): self
	{
		// registration
		$contactEmail = $data->contact_person_email;
		$registrationCustomUrl = $data->entry_form_url;
		$registrationQuestions = \array_filter([ // exclude all null items
			$data->additional_question_1,
			$data->additional_question_2,
			$data->additional_question_3,
		], fn($v, $k) => $v !== '', \ARRAY_FILTER_USE_BOTH);
		$registrationType = RegistrationType::from(
			RegistrationTypeEnum::fromScalar($data->registration_method),
			\array_map(fn(string $question) => RegistrationQuestion::from($question), $registrationQuestions),
			$contactEmail,
			$registrationCustomUrl,
		);


		// organizers
		$organizationalUnitName = $data->administrative_unit_name !== '' ? $data->administrative_unit_name : null;
		$organizationalUnitWebsite = $data->administrative_unit_web_url !== '' ? $data->administrative_unit_web_url : null;
		$organizers = $data->looking_forward_to_you !== '' ? $data->looking_forward_to_you : null;
		$responsiblePerson = $data->responsible_person !== '' ? $data->responsible_person : null;
		$organizer = Organizer::from(
			($organizationalUnitName !== null)
				? OrganizerOrganizationalUnit::from($organizationalUnitName, $organizationalUnitWebsite)
				: null,
			$responsiblePerson,
			$organizers,
			ContactPerson::from(
				$data->contact_person_name,
				$contactEmail,
				$data->contact_person_telephone,
			),
		);


		// invitation

		$food = $data->diet !== null
			? Food::fromScalar($data->diet)
			: Food::NOT_LISTED();

		/** @var Photo[] $invitationPresentationPhotos */
		$invitationPresentationPhotos = [];
		for ($i = 1; $i <= 6; $i++) {
			$photo = $data->{'additional_photo_' . $i};
			if ($photo !== null) {
				$invitationPresentationPhotos[] = Photo::from($photo);
			}
		}

		$invitationPresentationText = $data->invitation_text_4;
		$invitation = Invitation::from(
			$data->invitation_text_1,
			$data->invitation_text_2,
			$data->accommodation !== '' ? $data->accommodation : null,
			$food,
			$data->invitation_text_3,
			$data->working_hours,
			($invitationPresentationText !== null || \count($invitationPresentationPhotos) > 0)
				? Presentation::from($invitationPresentationText, $invitationPresentationPhotos)
				: null,
		);


		// related website
		$relatedWebsite = $data->web_url;
		$_relatedWebsite = null;
		if ($relatedWebsite !== null) {
			if ( ! self::startsWith($relatedWebsite, 'http')) { // count with no protocol typed URLs
				$relatedWebsite = 'http://' . $relatedWebsite;
			}

			$_relatedWebsite = $relatedWebsite;
		}

		return new self(
			$data->id,
			$data->name,
			$data->main_photo,
			\DateTimeImmutable::createFromFormat('Y-m-d', $data->date_from),
			\DateTimeImmutable::createFromFormat('Y-m-d', $data->date_to),
			Program::fromScalar($data->program),
			Place::from(
				$data->location->name,
				$data->location->gps_latitude !== null && $data->location->gps_longitude !== null
					? Coordinates::from($data->location->gps_latitude, $data->location->gps_longitude)
					: null,
			),
			$registrationType,
			$data->age_from,
			$data->age_to,
			$data->participation_fee !== null ? $data->participation_fee : null,
			$organizer,
			TargetGroup::fromScalar($data->indended_for),
			$invitation,
			new \DateTimeImmutable($data->start_date),
			$_relatedWebsite,
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


	public function getCoverPhotoPath(): ?string
	{
		return $this->coverPhotoPath;
	}


	public function getDateFrom(): \DateTimeImmutable
	{
		return $this->dateFrom;
	}


	public function getDateUntil(): \DateTimeImmutable
	{
		return $this->dateUntil;
	}


	public function getProgram(): Program
	{
		return $this->program;
	}


	public function getPlace(): Place
	{
		return $this->place;
	}


	public function getRegistrationType(): RegistrationType
	{
		return $this->registrationType;
	}


	public function getAgeFrom(): ?int
	{
		return $this->ageFrom;
	}


	public function getAgeUntil(): ?int
	{
		return $this->ageUntil;
	}


	public function getPrice(): ?string
	{
		return $this->price;
	}


	public function getOrganizer(): Organizer
	{
		return $this->organizer;
	}


	public function getTargetGroup(): TargetGroup
	{
		return $this->targetGroup;
	}


	public function getInvitation(): Invitation
	{
		return $this->invitation;
	}


	public function getStartDate(): ?\DateTimeImmutable
	{
		return $this->startDate;
	}


	public function getRelatedWebsite(): ?string
	{
		return $this->relatedWebsite;
	}


	/**
	 * Extracted from \Nette\Utils\Strings (v2.3)
	 * Starts the $haystack string with the prefix $needle?
	 */
	private static function startsWith(string $haystack, string $needle): bool
	{
		return \strncmp($haystack, $needle, \strlen($needle)) === 0;
	}

}
