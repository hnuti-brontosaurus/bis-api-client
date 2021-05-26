<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static EventType VOLUNTARY()
 * @method static EventType EXPERIENCE()
 * @method static EventType SPORT()
 * @method static EventType EDUCATIONAL_TALK()
 * @method static EventType EDUCATIONAL_COURSES()
 * @method static EventType EDUCATIONAL_OHB()
 * @method static EventType LEARNING_PROGRAM()
 * @method static EventType RESIDENTIAL_LEARNING_PROGRAM()
 * @method static EventType CLUB_MEETUP()
 * @method static EventType CLUB_TALK()
 * @method static EventType FOR_PUBLIC()
 * @method static EventType EKOSTAN()
 * @method static EventType EXHIBITION()
 * @method static EventType ACTION_GROUP()
 * @method static EventType INTERNAL()
 * @method static EventType GROUP_MEETING()
 */
final class EventType extends Enum
{
	use AutoInstances;

	protected const VOLUNTARY = 'pracovni'; // dobrovolnická
	protected const EXPERIENCE = 'prozitkova'; // zážitková
	protected const SPORT = 'sportovni';

	protected const EDUCATIONAL_TALK = 'prednaska'; // vzdělávací - přednášky
	protected const EDUCATIONAL_COURSES = 'vzdelavaci'; // vzdělávací - kurzy, školení
	protected const EDUCATIONAL_OHB = 'ohb'; // vzdělávací - kurz ohb
	protected const LEARNING_PROGRAM = 'vyuka'; // výukový program
	protected const RESIDENTIAL_LEARNING_PROGRAM = 'pobyt'; // pobytový výukový program

	protected const CLUB_MEETUP = 'klub'; // klub - setkání
	protected const CLUB_TALK = 'klub-predn'; // klub - přednáška
	protected const FOR_PUBLIC = 'verejnost'; // akce pro veřejnost
	protected const EKOSTAN = 'ekostan';
	protected const EXHIBITION = 'vystava';
	protected const ACTION_GROUP = 'akcni'; // akční skupina
	protected const INTERNAL = 'jina'; // interní akce (VH a jiné)
	protected const GROUP_MEETING = 'schuzka'; // oddílová, družinová schůzka
}
