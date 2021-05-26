<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;


final class Endpoint
{
	private const ENDPOINT_BASE_URL = 'https://klub-diakonie-devel.herokuapp.com/api';


	public static function AUTHENTICATION(): string
	{
		return \sprintf('%s/o/token/', self::ENDPOINT_BASE_URL);
	}

	public static function EVENT(int $id): string
	{
		return \sprintf('%s/bronto/event/%d/', self::ENDPOINT_BASE_URL, $id);
	}

	public static function EVENTS(): string
	{
		return \sprintf('%s/bronto/event/', self::ENDPOINT_BASE_URL);
	}

	public static function ADMINISTRATIVE_UNITS(): string
	{
		return \sprintf('%s/bronto/administrative_unit/', self::ENDPOINT_BASE_URL);
	}

	public static function ADD_ATTENDEE_TO_EVENT(): string
	{
		return \sprintf('%s/bronto/register_userprofile_interaction/', self::ENDPOINT_BASE_URL);
	}

}
