<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class EventTickets
 * @package Futurolan\WeezeventBundle\Entity
 */
class EventTickets
{
    /**
     * @var EventTicket[]
     * @Serializer\Type("array<Futurolan\WeezeventBundle\Entity\EventTicket>")
     */
    private $events = [];

    /**
     * @return EventTicket[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}