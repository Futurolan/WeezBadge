<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Category
 * @package Futurolan\WeezeventBundle\Entity
 */
class Category
{
    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @var Ticket[]
     * @Serializer\Type("array<Futurolan\WeezeventBundle\Entity\Ticket>")
     */
    private $tickets;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return null|Ticket[]
     */
    public function getTickets(): ?array
    {
        return $this->tickets;
    }
}