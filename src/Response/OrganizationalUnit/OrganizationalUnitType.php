<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\OrganizationalUnit;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static OrganizationalUnitType CLUB()
 * @method static OrganizationalUnitType BASE()
 * @method static OrganizationalUnitType REGIONAL()
 * @method static OrganizationalUnitType OFFICE()
 */
final class OrganizationalUnitType extends Enum
{
	use AutoInstances;

	protected const CLUB = 'club';
	protected const BASE = 'basic_section';
	protected const REGIONAL = 'regional_center';
	protected const OFFICE = 'headquarter';
}
