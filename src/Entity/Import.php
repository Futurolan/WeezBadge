<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Import
 * @package App\Entity
 */
class Import
{
    /**
     * @var int|null
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     */
    private $eventID;

    /**
     * @var int|null
     * @Assert\NotBlank
     * @Assert\GreaterThan(
     *     value = 0,
     *     message = "Le type de badge doit être défini."
     * )
     */
    private $ticketID;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private $csv;

    /**
     * @var bool|null
     */
    private $notify;

    /**
     * @return int|null
     */
    public function getEventID(): ?int
    {
        return $this->eventID;
    }

    /**
     * @param mixed $eventID
     */
    public function setEventID($eventID): void
    {
        if ( !is_null($eventID) ) { $eventID = (int)$eventID; }
        $this->eventID = $eventID;
    }

    /**
     * @return int|null
     */
    public function getTicketID(): ?int
    {
        return $this->ticketID;
    }

    /**
     * @param mixed $ticketID
     */
    public function setTicketID($ticketID): void
    {
        if ( !is_null($ticketID) ) { $ticketID = (int)$ticketID; }
        $this->ticketID = $ticketID;
    }

    /**
     * @return string|null
     */
    public function getCsv(): ?string
    {
        return $this->csv;
    }

    /**
     * @param string $csv
     */
    public function setCsv(string $csv): void
    {
        $this->csv = $csv;
    }

    /**
     * @return bool|null
     */
    public function getNotify(): ?bool
    {
        return $this->notify;
    }

    /**
     * @param bool|null $notify
     */
    public function setNotify(?bool $notify): void
    {
        $this->notify = $notify;
    }
}