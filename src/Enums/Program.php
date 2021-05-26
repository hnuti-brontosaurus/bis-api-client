<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Program NONE()
 * @method static Program NATURE()
 * @method static Program SIGHTS()
 * @method static Program BRDO()
 * @method static Program EKOSTAN()
 * @method static Program PSB()
 * @method static Program EDUCATION()
 */
final class Program extends Enum
{
	use AutoInstances;

	protected const NONE = '';
	protected const NATURE = 'nature';
	protected const SIGHTS = 'monuments';
	protected const BRDO = 'children_section';
	protected const EKOSTAN = 'eco_consulting';
	protected const PSB = 'PsB';
	protected const EDUCATION = 'education';
}
