<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Psr7\Request;
use HnutiBrontosaurus\BisClient\Request\ToArray;
use Psr\Http\Client\NetworkExceptionInterface;


final class HttpClient
{

	public function __construct(
		private AuthorizationToken $authorizationToken,
		private Client $client,
	) {}


	/**
	 * @throws UnableToProcessRequest
	 * @throws NotFound
	 * @throws ConnectionToBisFailed
	 */
	public function send(
		string $method,
		string $endpoint,
		?ToArray $parameters = null,
		?ToArray $data = null,
	): array|\stdClass|null
	{
		$queryString = $parameters !== null
			? '?' . \http_build_query($parameters->toArray())
			: '';

		// see Guzzle exceptions docs: https://docs.guzzlephp.org/en/stable/quickstart.html#exceptions
		try {
			$response = $this->client->send(new Request(
				$method,
				$endpoint . $queryString,
				[
					'Authorization' => 'Bearer ' . $this->authorizationToken->toString(),
					'Content-Type' => 'application/json',
				],
				\json_encode($data !== null ? $data->toArray() : []),
			));

		} catch (ClientException $e) { // 4xx errors
			if ($e->getCode() === 400) {
				throw UnableToProcessRequest::withPrevious($e);
			}

			if ($e->getCode() === 404) {
				throw NotFound::withPrevious($e);
			}

			throw ConnectionToBisFailed::withPrevious($e);

		} catch (ServerException $e) { // 5xx errors
			throw ConnectionToBisFailed::withPrevious($e);

		} catch (TooManyRedirectsException $e) {
			throw ConnectionToBisFailed::withPrevious($e);

		} catch (NetworkExceptionInterface $e) { // problem with connection
			throw ConnectionToBisFailed::withPrevious($e);

		} catch (GuzzleException $e) { // fallback catch-all exception
			throw ConnectionToBisFailed::withPrevious($e);
		}

		return \json_decode($response->getBody()->getContents());
	}

}
