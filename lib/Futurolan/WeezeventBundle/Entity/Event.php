<?php


namespace Futurolan\WeezeventBundle\Entity;


use JMS\Serializer\Annotation as Serializer;

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


}