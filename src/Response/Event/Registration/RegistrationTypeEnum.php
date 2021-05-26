<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Registration;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static RegistrationTypeEnum BRONTOWEB()
 * @method static RegistrationTypeEnum EMAIL()
 * @method static RegistrationTypeEnum EXTERNAL_WEBPAGE()
 * @method static RegistrationTypeEnum NONE()
 * @method static RegistrationTypeEnum DISABLED()
 */
final class RegistrationTypeEnum extends Enum
{
	use AutoInstances;

	protected const BRONTOWEB = 'standard';
	protected const EMAIL = 'by_email';
	protected const EXTERNAL_WEBPAGE = 'other_electronic';
	protected const NONE = 'not_required';
	protected const DISABLED = 'full';
}
