<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\Request\Event\EventAttendee;

$client = require_once __DIR__ . '/bootstrap.php';


// -----------------------------
// add attendee test
// -----------------------------

$addAttendee = function (int $eventId) use ($client): void
{
	$client->addAttendee(new EventAttendee(
		$eventId,
		'Jan',
		'Novák',
		DateTimeImmutable::createFromFormat('Y-m-d', '2000-05-01'),
		'123 456 789',
		'jan.novak@example.com',
		'prosím, abych tam měl nachystanou teplou peřinu',
		['odpověď č. 1', '', 'odpověď č. 3'],
	));
};
// uncomment if you need to test it otherwise it would post on every page load
//$addAttendee(eventId: 13703); // ⚠  do not forget to customize event id not to pollute real events with testing data


// -----------------------------
// retrieving information test
// -----------------------------

echo '<div style="display: grid; grid-template-columns: repeat(3, 1fr)">';

	echo '<div>';
		echo '<h2>Event</h2>';
		dump($client->getEvent(13063));
	echo '</div>';

	echo '<div style="flex-basis: 50%">';
		echo '<h2>Events</h2>';

		foreach ($client->getEvents() as $event) {
			dump($event);
		}
	echo '</div>';

	echo '<div>';
		echo '<h2>Organizational units</h2>';

		foreach ($client->getOrganizationalUnits() as $unit) {
			dump($unit);
		}
	echo '</div>';

echo '</div>';
