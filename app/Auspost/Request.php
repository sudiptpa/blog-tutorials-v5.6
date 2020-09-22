<?php

namespace App\Auspost;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Throwable;

/**
 * Class Request
 * @package App\Auspost
 */
class Request
{
    /**
     * @var string
     */
    protected $url_prefix = 'https://digitalapi.auspost.com.au';

    /**
     * The API key.
     *
     * @var string
     */
    protected $api_key;

    /**
     * The guzzle http client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Create a new request instance.
     *
     * @param string $api_key
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $this->client = new Client();
    }

    /**
     * @param string $uri
     * @param array  $parameters
     * @param string $method
     *
     * @return \App\Auspost\Response
     */
    public function make($uri, array $parameters = [], $method = 'post')
    {
        $params = [
            'headers' => [
                'Content-Type' => 'application/json',
                'AUTH-KEY' => $this->api_key,
            ],
        ];

        if (in_array(strtoupper($method), ['POST'])) {
            $params['body'] = json_encode($parameters);
        }

        try {
            $response = $this->client->{$method}($uri, $params);
        } catch (Throwable $e) {
            return [];
        }

        return new Response($response);
    }

    /**
     * @param array $parameters
     */
    public function locality(array $parameters)
    {
        $uri = vsprintf('%s/postcode/search.json', [
            $this->url_prefix,
        ]);

        if (sizeof($parameters)) {
            $uri .= '?' . http_build_query($parameters);
        }

        return $this->make($uri, $parameters, 'get');
    }
}
