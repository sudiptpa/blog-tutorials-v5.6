<?php

namespace App\Auspost;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Class Response.
 * @package App\Auspost
 */
class Response extends GuzzleResponse
{
    /**
     * The guzzle http client response.
     *
     * @var \GuzzleHttp\Message\Response
     */
    protected $response;

    /**
     * Create a new response instance.
     *
     * @param GuzzleResponse $response
     */
    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function toJson()
    {
        return (string) $this->response->getBody();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        $response = $this->response;

        if (is_object($response) && method_exists($response, 'getStatusCode')) {
            $statusCode = $this->response->getStatusCode();

            return $statusCode >= 200 && $statusCode < 300;
        }
    }
}
