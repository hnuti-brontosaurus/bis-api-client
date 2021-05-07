<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static TargetGroup EVERYONE()
 * @method static TargetGroup ADULTS()
 * @method static TargetGroup CHILDREN()
 * @method static TargetGroup FAMILIES()
 * @method static TargetGroup FIRST_TIME_ATTENDEES()
 */
final class TargetGroup extends Enum
{
	use AutoInstances;

	protected const EVERYONE = 'everyone';
	protected const ADULTS = 'adolescents_and_adults';
	protected const CHILDREN = 'children';
	protected const FAMILIES = 'parents_and_children';
	protected const FIRST_TIME_ATTENDEES = 'newcomers';
}
