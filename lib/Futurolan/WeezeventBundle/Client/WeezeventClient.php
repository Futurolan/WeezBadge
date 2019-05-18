<?php


namespace Futurolan\WeezeventBundle\Client;


/**
 * Class WeezeventClient
 * @package Futurolan\WeezeventBundle\Client
 */
class WeezeventClient
{
    /** @var string */
    private $apiUrl;

    /** @var string */
    private $apiKey;

    /** @var string */
    private $apiToken;


    /**
     * WeezeventClient constructor.
     * @param string $apiUrl
     * @param string $apiKey
     * @param string $apiToken
     */
    public function __construct(string $apiUrl, string $apiKey, string $apiToken)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->apiToken = $apiToken;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getToken()
    {
        return $this->apiToken;
    }
}