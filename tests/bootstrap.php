<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClientFactory;
use Tracy\Debugger;


require_once __DIR__ . '/../vendor/autoload.php';

Debugger::enable();

// client factory
// wrapped in IIFE not to pollute script with client* variables
return (function () {
	$secret = require_once __DIR__ . '/secret.php';
	['clientId' => $clientId, 'clientSecret' => $clientSecret] = $secret;

	return (new BisClientFactory(
		$clientId,
		$clientSecret,
	))->create();
})();
