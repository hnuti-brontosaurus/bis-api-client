<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;


final class Authenticator
{

	private ?AuthorizationToken $token;

	public function __construct(
		private string $clientId,
		private string $clientSecret,
		private Client $httpClient,
	) {
		$this->token = null; // not yet authenticated
	}


	/**
	 * @throws UnableToAuthorize
	 * @throws ConnectionToBisFailed
	 */
	public function authenticate(): AuthorizationToken
	{
		if ($this->token !== null) {
			return $this->token;
		}

		try {
			$response = $this->httpClient->send(new Request(
				'POST',
				Endpoint::AUTHENTICATION(),
				[
					'Accept' => 'application/json',
					'Content-Type' => 'application/json',
				],
				\json_encode([
					'grant_type' => 'client_credentials',
					'client_id' => $this->clientId,
					'client_secret' => $this->clientSecret,
				]),
			));
		} catch (ClientException $e) {
			if ($e->getCode() === 401) {
				throw UnableToAuthorize::withPrevious($e);
			}

			throw ConnectionToBisFailed::withPrevious($e);

		} catch (GuzzleException $e) {
			throw ConnectionToBisFailed::withPrevious($e);
		}

		$payload = \json_decode($response->getBody()->getContents());
		$this->token = AuthorizationToken::from($payload->access_token);
		return $this->token;
	}

}
