<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use GuzzleHttp\Client;


/*
 * We can not count on using dependency injection container in applications using this library.
 * But we can say that BisClientFactory should be called only once per request,
 * so we build dependencies here in constructor.
 *
 */
final class BisClientFactory
{
	private Authenticator $bisAuthenticator;
	private Client $httpClient;


	public function __construct(
		private string $clientId,
		private string $clientSecret,
	) {
		$this->httpClient = new Client();
		$this->bisAuthenticator = new Authenticator(
			$this->clientId,
			$this->clientSecret,
			$this->httpClient,
		);
	}


	/**
	 * @throws UnableToAuthorize
	 * @throws ConnectionToBisFailed
	 */
	public function create(): BisClient
	{
		$token = $this->bisAuthenticator->authenticate();
		return new BisClient(new HttpClient(
			$token,
			$this->httpClient,
		));
	}

}
