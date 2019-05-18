<?php


namespace Futurolan\WeezeventBundle\Entity;


use JMS\Serializer\Annotation as Serializer;

class Events
{
    /**
     * @var Event[]
     * @Serializer\Type("array<Futurolan\WeezeventBundle\Entity\Event>")
     */
    private $events = [];


    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}