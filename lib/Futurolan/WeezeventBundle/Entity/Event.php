<?php


namespace Futurolan\WeezeventBundle\Entity;


use JMS\Serializer\Annotation as Serializer;

/**
 * Class Event
 * @package Futurolan\WeezeventBundle\Entity
 */
class Event
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
    private $id_orga;

    /**
     * @var Dates
     * @Serializer\Type("Futurolan\WeezeventBundle\Entity\Dates")
     */
    private $date;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $participants;

    /**
     * @var bool
     * @Serializer\Type("bool")
     */
    private $multiple_dates;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIdOrga(): int
    {
        return $this->id_orga;
    }

    /**
     * @param int $id_orga
     */
    public function setIdOrga(int $id_orga): void
    {
        $this->id_orga = $id_orga;
    }

    /**
     * @return Dates
     */
    public function getDate(): Dates
    {
        return $this->date;
    }

    /**
     * @param Dates $date
     */
    public function setDate(Dates $date): void
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getParticipants(): int
    {
        return $this->participants;
    }

    /**
     * @param int $participants
     */
    public function setParticipants(int $participants): void
    {
        $this->participants = $participants;
    }

    /**
     * @return bool
     */
    public function isMultipleDates(): bool
    {
        return $this->multiple_dates;
    }

    /**
     * @param bool $multiple_dates
     */
    public function setMultipleDates(bool $multiple_dates): void
    {
        $this->multiple_dates = $multiple_dates;
    }
}