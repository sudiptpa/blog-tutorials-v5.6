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
     * @return mixed
     */
    public function toJson()
    {
        return (string) $this->response->getBody();
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }
}
