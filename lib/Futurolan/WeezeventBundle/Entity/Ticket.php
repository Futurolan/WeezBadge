<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;
use \DateTime;

/**
 * Class Ticket
 * @package Futurolan\WeezeventBundle\Entity
 */
class Ticket
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
     * @var int
     * @Serializer\Type("int")
     */
    private $price;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $group_size;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $participants;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $quotas;

    /**
     * @var DateTime
     * @Serializer\Type("DateTime")
     */
    private $start_sale;

    /**
     * @var DateTime
     * @Serializer\Type("DateTime")
     */
    private $end_sale;

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
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getGroupSize(): int
    {
        return $this->group_size;
    }

    /**
     * @return int
     */
    public function getParticipants(): int
    {
        return $this->participants;
    }

    /**
     * @return int
     */
    public function getQuotas(): int
    {
        return $this->quotas;
    }

    /**
     * @return DateTime
     */
    public function getStartSale(): DateTime
    {
        return $this->start_sale;
    }

    /**
     * @return DateTime
     */
    public function getEndSale(): DateTime
    {
        return $this->end_sale;
    }
}