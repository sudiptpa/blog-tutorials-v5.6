<?php

namespace App\Auspost;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class Request
 * @package App\Auspost
 */
class Request
{
    const END_POINT = 'https://digitalapi.auspost.com.au/postcode/search.json';

    /**
     * The API token.
     *
     * @var string
     */
    protected $token;

    /**
     * The guzzle http client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Create a new request instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->client = new Client();
    }

    public function getEndpoint()
    {
        return self::END_POINT;
    }

    /**
     * Retrive data via API call from Auspost server.
     *
     * @param array $parameters
     * @param $method
     *
     * @return App\Auspost\Response
     */
    public function send(array $parameters = [], $method = 'get')
    {
        $url = $this->getEndpoint() . '?' . http_build_query($parameters);

        $parameters = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Auth-Key' => $this->token,
            ],
        ];

        try {
            $response = $this->client->request($method, $url, $parameters);

        } catch (ClientException $exception) {
            return $exception;
        }

        return with(new Response($response))->toArray();
    }
}
