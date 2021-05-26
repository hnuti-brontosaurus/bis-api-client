<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Event;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Ordering DATE_FROM()
 * @method static Ordering DATE_TO()
 */
final class Ordering extends Enum
{
	use AutoInstances;

	protected const DATE_FROM = 'date_from';
	protected const DATE_TO = 'date_to';
}
