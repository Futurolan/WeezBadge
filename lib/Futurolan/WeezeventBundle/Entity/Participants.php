<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Participants
 * @package Futurolan\WeezeventBundle\Entity
 */
class Participants
{
    /**
     * @var Participant[]
     * @Serializer\Type("array<Futurolan\WeezeventBundle\Entity\Participant>")
     */
    private $participants = [];


    /**
     * @return Participant[]
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }
}