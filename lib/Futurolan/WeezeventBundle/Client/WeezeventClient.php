<?php


namespace Futurolan\WeezeventBundle\Client;



use Futurolan\WeezeventBundle\Entity\Event;
use Futurolan\WeezeventBundle\Entity\Events;
use Futurolan\WeezeventBundle\Entity\Participant;
use Futurolan\WeezeventBundle\Entity\Participants;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\Serializer;

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
        $this->serializer = $serializer;
    }

    /**
     * @param bool $includeClosed
     * @return Event[]
     * @throws GuzzleException
     */
    public function getEvents(bool $includeClosed = false)
    {
        $this->client = new Client();
        $response = $this->client->request('GET', $this->buildQuery($this->apiUrl.Constants::EVENTS_PATH, ['include_closed' => ( $includeClosed ? 'true' : 'false' )]));
        /** @var Events $data */
        $data = $this->serializer->deserialize($response->getBody(), Events::class, 'json');

        return $data->getEvents();
    }

    /**
     * @param string $eventId
     * @return Participant[]
     * @throws GuzzleException
     */
    public function getParticipantsByEvent(string $eventId)
    {
        $this->client = new Client();
        $response = $this->client->request('GET', $this->buildQuery($this->apiUrl.Constants::PARTICIPANT_LIST_PATH, ['id_event' => [$eventId]]));
        dump($response->getBody()->getContents());
        /** @var Participants $data */
        $data = $this->serializer->deserialize($response->getBody(), Participants::class, 'json');
        return $data->getParticipants();
    }

    /**
     * @param string $url
     * @param array $params
     * @return string
     */
    private function buildQuery(string $url, array $params = [])
    {
        $query = http_build_query(array_merge(['api_key' => $this->apiKey, 'access_token' => $this->apiToken], $params));
        return $url.'?'.$query;
    }
}