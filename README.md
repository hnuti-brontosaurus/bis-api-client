This library allows you to easily communicate with BIS API.

# Installation

## Composer

Add path to `repositories`:

```
{
	"url": "https://github.com/hnuti-brontosaurus/php-bis-api-client.git",
	"type": "vcs"
}
```

and install package:
```
composer require hnuti-brontosaurus/php-bis-api-client
```

## Manually

Download latest version from [github](https://github.com/hnuti-brontosaurus/php-bis-api-client/releases) to your computer.


# Usage

First you need to create client instance. Note that you need to obtain client ID and secret from BIS administrator
to be able to authenticate against BIS.

```php
$client = (new BisClientFactory(
	'clientId',
	'clientSecret',
))->create();
```

Now you can perform any of available operations.

## Events

### Single event

Retrieve all information about single event:

```php
$event = $client->getEvent($id);

// examples of reading data
$event->getName();
$event->getOrganizer()->getResponsiblePerson();
$event->getRegistrationType()->isOfTypeCustomWebpage();
$event->getPlace()->getCoordinates();
```

### More events

Retrieve all information about multiple events.

Basic usage:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();
$events = $client->getEvents($parameters); // $parameters are optional

// example of reading data
foreach ($events as $event) {
    $event->getName();
}
```

#### Filters

You can filter in many ways:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();

// only events of "voluntary" type
$parameters->setType(\HnutiBrontosaurus\BisClient\Enums\EventType::VOLUNTARY());

// only events of "PsB" program
$parameters->setProgram(\HnutiBrontosaurus\BisClient\Enums\Program::PSB());

// only events of "first time attendees" target group
$parameters->setTargetGroup(\HnutiBrontosaurus\BisClient\Enums\TargetGroup::FIRST_TIME_ATTENDEES());

// only events organized by organizational unit with ID 123
$parameters->setOrganizedBy(123);

// excludes running events
$parameters->excludeRunning();

$events = $client->getEvents($parameters);
```

For type, program and target group, you can set more values at once:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();

$parameters->setTypes([
    \HnutiBrontosaurus\BisClient\Enums\EventType::VOLUNTARY(),
    \HnutiBrontosaurus\BisClient\Enums\EventType::SPORT(),
]);

$events = $client->getEvents($parameters);
```

Note that each method call rewrites the previous one:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();

// sets "voluntary" type
$parameters->setType(\HnutiBrontosaurus\BisClient\Enums\EventType::VOLUNTARY());
// rewrites type with "sport"
$parameters->setType(\HnutiBrontosaurus\BisClient\Enums\EventType::SPORT());

$events = $client->getEvents($parameters);
```

#### Sorting

You can even use some basic sorting options:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();

// sort events by date from or date to
$parameters->orderByDateFrom();
$parameters->orderByDateTo(); // default

$events = $client->getEvents($parameters);
```

### Adding attendee

You can add attendee to an event:

```php
$client->addAttendee(new \HnutiBrontosaurus\BisClient\Request\Event\EventAttendee(
    123, // event ID
    'Jan', // first name
    'Novák', // last name
    '12.3.2004', // birth date
    '123 456 789', // phone number
    'jan@novak.cz', // e-mail address
    'poznámka', // note
    ['odpověď na otázku č. 1', '', 'odpověď na otázku č. 3'], // answers to optional questions (optional)
));
```

## Organizational units

Retrieve all information about all organizational units:

```php
$organizationalUnits = $client->getOrganizationalUnits();

// example of reading data
foreach ($organizationalUnits as $organizationalUnit) {
    $organizationalUnit->getName();
    $organizationalUnit->getCity();
    $organizationalUnit->getChairman();
    $organizationalUnit->getCoordinates();
}
```

# Development

## Installation

```
composer install
```

## Structure

- `docs` – instruction on how connection between brontoweb and BIS works (todo: move to brontoweb repo)
- `src` – source code
    - `Enums` – basic enum types
    - `Request` – request-related value objects
    - `Response` – request-related value objects and exceptions
    - `BisClient` – client itself, serves for making requests to BIS API
    - `BisClientFactory` – collects configuration data, ensures authentication against BIS and returns `BisClient`
    - `HttpClient` – wrapper around Guzzle client which adds BIS API specific pieces into the request
- `tests` – test code

**Note that this library bundles Guzzle HTTP client as we can not rely on having composer in user's codebase.**

## Tests

This library has just `tests/index.php` which – if run on a webserver – will
pass or fail visually – no error and results output or an exception.

Note that you have to obtain client ID and secret as well to be able to run the test. Ask BIS administrator to get it, copy `tests/secret.template.php` to `tests/secret.php` and insert credentials there.
