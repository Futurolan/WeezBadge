<?php


namespace Futurolan\WeezeventBundle\Client;



use Futurolan\WeezeventBundle\Entity\Event;
use Futurolan\WeezeventBundle\Entity\Events;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;

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

    /** @var Client */
    private $client;

    /** @var Serializer */
    private $serializer;

    /**
     * WeezeventClient constructor.
     * @param Serializer $serializer
     * @param string $apiUrl
     * @param string $apiKey
     * @param string $apiToken
     */
    public function __construct(Serializer $serializer, string $apiUrl, string $apiKey, string $apiToken)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->apiToken = $apiToken;
        $this->client = new Client();
        $this->serializer = $serializer;
    }

    /**
     * @return mixed|ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEvents()
    {
        $url = $this->apiUrl.Constants::EVENTS_PATH;
        $response = $this->client->request('GET', $this->buildUrl($url));
        dump($response->getBody()->getContents());
        $data = $this->serializer->deserialize($response->getBody(), Events::class, 'json');

        return $data;
    }

    private function buildUrl(string $url)
    {
        return $url
            ."?api_key=".$this->apiKey
            ."&access_token=".$this->apiToken
        ;
    }
}