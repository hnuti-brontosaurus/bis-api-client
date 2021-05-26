<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Invitation;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Food NOT_LISTED()
 * @method static Food CHOOSEABLE()
 * @method static Food VEGETARIAN()
 * @method static Food NON_VEGETARIAN()
 */
final class Food extends Enum
{
	use AutoInstances;

	protected const NOT_LISTED = '';
	protected const CHOOSEABLE = 'can_choose';
	protected const VEGETARIAN = 'non_vegetarian';
	protected const NON_VEGETARIAN = 'vegetarian';
}
