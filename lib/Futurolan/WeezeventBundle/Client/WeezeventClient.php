<?php


namespace Futurolan\WeezeventBundle\Client;

use Futurolan\WeezeventBundle\Entity\Event;
use Futurolan\WeezeventBundle\Entity\Events;
use Futurolan\WeezeventBundle\Entity\EventTicket;
use Futurolan\WeezeventBundle\Entity\EventTickets;
use Futurolan\WeezeventBundle\Entity\Participant;
use Futurolan\WeezeventBundle\Entity\ParticipantPost;
use Futurolan\WeezeventBundle\Entity\Participants;
use Futurolan\WeezeventBundle\Entity\Ticket;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\Serializer;
use \Exception as Exception;

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

    /** @var string */
    private $apiUsername;

    /** @var string */
    private $apiPassword;

    /**
     * WeezeventClient constructor.
     * @param Serializer $serializer
     * @param string $apiUrl
     * @param string $apiKey
     * @param string $apiUsername
     * @param string $apiPassword
     */
    public function __construct(Serializer $serializer, string $apiUrl, string $apiKey, string $apiUsername, string $apiPassword)
    {
        $this->apiUrl = $apiUrl;
        $this->serializer = $serializer;
        $this->apiKey = $apiKey;
        $this->apiUsername = $apiUsername;
        $this->apiPassword = $apiPassword;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getNewToken()
    {
        $this->client = new Client();
        $response = $this->client->request('POST', $this->buildTokenQuery());
        $data = $this->serializer->deserialize($response->getBody(), 'array', 'json');
        return $data['accessToken'];
    }

    /**
     * @param bool $includeClosed
     * @return Event[]
     * @throws GuzzleException
     */
    public function getEvents(bool $includeClosed = false)
    {
        $this->client = new Client();
        $response = $this->client->request('GET', $this->buildQuery($this->apiUrl.Constants::EVENTS_PATH, [
            'include_closed' => ( $includeClosed ? 'true' : 'false' ),
            'include_without_sales' => true,
        ]));
        /** @var Events $data */
        $data = $this->serializer->deserialize($response->getBody(), Events::class, 'json');

        return $data->getEvents();
    }

    /**
     * @param string $eventId
     * @return Event|null
     * @throws GuzzleException
     */
    public function getEvent(?string $eventId)
    {
        if ( empty($eventId) ) { return null; }
        $events = $this->getEvents(true);
        foreach ($events as $event) {
            if ( $event->getId() === (int)$eventId ) {
                return $event;
            }
        }
        return null;
    }

    /**
     * @param string $eventId
     * @return Participant[]
     * @throws GuzzleException
     */
    public function getParticipantsByEvent(string $eventId)
    {
        $this->client = new Client();
        $response = $this->client->request('GET', $this->buildQuery($this->apiUrl.Constants::PARTICIPANT_LIST_PATH, ['id_event' => [$eventId], 'full' => true]));
        /** @var Participants $data */
        $data = $this->serializer->deserialize($response->getBody(), Participants::class, 'json');
        return $data->getParticipants();
    }

    /**
     * @param string $ticketId
     * @return Participant[]
     * @throws GuzzleException
     */
    public function getParticipantsByTicket(string $ticketId)
    {
        $this->client = new Client();
        $response = $this->client->request('GET', $this->buildQuery($this->apiUrl.Constants::PARTICIPANT_LIST_PATH, ['id_ticket' => [$ticketId], 'full' => true]));
        /** @var Participants $data */
        $data = $this->serializer->deserialize($response->getBody(), Participants::class, 'json');
        return $data->getParticipants();
    }


    /**
     * @param string $eventId
     * @return EventTicket
     * @throws GuzzleException
     */
    public function getTicketsByEvent(string $eventId)
    {
        $this->client = new Client();
        $response = $this->client->request('GET', $this->buildQuery($this->apiUrl.Constants::TICKETS_PATH, ['id_event' => [$eventId]]));

        /** @var EventTickets $data */
        $data = $this->serializer->deserialize($response->getBody(), EventTickets::class, 'json');
        return current($data->getEvents());
    }

    /**
     * @param string $eventId
     * @param string $categoryId
     * @return Ticket[]|null
     * @throws GuzzleException
     */
    public function getCategory(string $eventId, string $categoryId)
    {
        $eventTicket = $this->getTicketsByEvent($eventId);
        foreach($eventTicket->getCategories() as $category) {
            if ( $category->getId() === (int)$categoryId ) {
                return $category->getTickets();
            }
        }
        return null;
    }

    /**
     * @param string $eventId
     * @param string $ticketId
     * @return Ticket|null
     * @throws GuzzleException
     */
    public function getTicket(string $eventId, string $ticketId)
    {
        $eventTicket = $this->getTicketsByEvent($eventId);
        foreach($eventTicket->getCategories() as $category) {
            foreach($category->getTickets() as $ticket) {
                if ( $ticket->getId() === (int)$ticketId ) { return $ticket; }
            }
        }
        return null;
    }

    /**
     * @param ParticipantPost $participant
     * @return array
     * @throws GuzzleException
     */
    public function addParticipant(ParticipantPost $participant)
    {
        return $this->addParticipants([$participant]);
    }

    /**
     * Add an array of ParticipantPost to Weezevent
     *
     * @param ParticipantPost[] $participants
     * @return array
     * @throws GuzzleException
     */
    public function addParticipants(array $participants)
    {
        if ( empty($participants) ) { return []; }
        $this->client = new Client();
        $data = ['participants' => $participants, 'return_ticket_url' => false];
        $response = $this->client->request('POST', $this->buildQuery($this->apiUrl.Constants::PARTICIPANTS_PATH, []),
            [
                'form_params' => array('data' => $this->serializer->serialize($data, 'json'))
            ]
        );
        return $this->serializer->deserialize($response->getBody(), 'array', 'json');
    }

    /**
     * Delete Participant
     * https://api.weezevent.com/doc/v3#participantsdelete
     *
     * @param string $eventId
     * @param string $participantId
     * @return bool
     * @throws GuzzleException
     */
    public function deleteParticipant(string $eventId, string $participantId)
    {
        $this->client = new Client();
        $data = $this->serializer->serialize(['participants' => [['id_evenement' => (int)$eventId, 'id_participant' => $participantId]]], 'json');
        $response = $this->client->request('DELETE', $this->buildQuery($this->apiUrl.Constants::PARTICIPANTS_PATH, []),
            [
                'form_params' => array('data' => $data)
            ]
        );
        $responseArray = $this->serializer->deserialize($response->getBody(), 'array', 'json');
        if ( key_exists('total_deleted', $responseArray) && $responseArray['total_deleted'] === 1 ) {
            return true;
        }
        return false;
    }

    /**
     * @param string $eventId
     * @param string $participantId
     * @throws GuzzleException
     * @return string|null
     */
    public function getBadgeUrl(string $eventId, string $participantId)
    {
        $this->client = new Client();
        $data = $this->serializer->serialize(['participants' => [['id_evenement' => (int)$eventId, 'id_participant' => $participantId]], 'return_ticket_url' => true], 'json');
        $response = $this->client->request('PATCH', $this->buildQuery($this->apiUrl.Constants::PARTICIPANTS_PATH, []),
            [
                'form_params' => array('data' => $data)
            ]
        );
        $responseArray = $this->serializer->deserialize($response->getBody(), 'array', 'json');
        if ( key_exists('participants', $responseArray) && count($responseArray['participants']) === 1 && key_exists('ticket_url', $responseArray['participants'][0]) ) {
            return $responseArray['participants'][0]['ticket_url'];
        }
        return null;
    }

    /**
     * @param string $url
     * @param array $params
     * @return string
     * @throws Exception
     */
    private function buildQuery(string $url, array $params = [])
    {
        $query = http_build_query(array_merge(['api_key' => $this->apiKey, 'access_token' => $this->getApiToken()], $params));
        return $url.'?'.$query;
    }

    /**
     * @return string
     */
    private function buildTokenQuery()
    {
        $query = http_build_query(['api_key' => $this->apiKey, 'username' => $this->apiUsername, 'password' => $this->apiPassword]);
        return $this->apiUrl.Constants::ACCESS_TOKEN.'?'.$query;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getApiToken(): string
    {
        if ( empty($this->apiToken) ) { throw new Exception("Le token API est vide."); }
        return $this->apiToken;
    }

    /**
     * @param string $apiToken
     */
    public function setApiToken(?string $apiToken): void
    {
        $this->apiToken = $apiToken;
    }

    /**
     * @return bool
     */
    public function isApiAccessValid()
    {
        return ( empty($this->apiToken) ? false : true );
    }
}