<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Log
 * @package App\Entity
 * @ORM\Entity()
 * @UniqueEntity("id")
 */
class Log
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $createdID;

    /**
     * @var string
     * @ORM\Column(type="string", length=180)
     */
    private $createdEmail;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $createdName;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdDate;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deletedID;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $deletedEmail;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $deletedName;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedDate;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $eventID;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $ticketID;

    /**
     * @var integer
     * @ORM\Column(name="participantid", type="integer", unique=true)
     */
    private $participantID;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $hash;

    /**
     * Log constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->createdDate = new DateTime();
    }

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
     * @return int
     */
    public function getCreatedID(): int
    {
        return $this->createdID;
    }

    /**
     * @param int $createdID
     */
    public function setCreatedID(int $createdID): void
    {
        $this->createdID = $createdID;
    }

    /**
     * @return string
     */
    public function getCreatedEmail(): string
    {
        return $this->createdEmail;
    }

    /**
     * @param string $createdEmail
     */
    public function setCreatedEmail(string $createdEmail): void
    {
        $this->createdEmail = $createdEmail;
    }

    /**
     * @return string|null
     */
    public function getCreatedName(): ?string
    {
        return $this->createdName;
    }

    /**
     * @param string|null $createdName
     */
    public function setCreatedName(?string $createdName): void
    {
        $this->createdName = $createdName;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate(): DateTime
    {
        return $this->createdDate;
    }

    /**
     * @param DateTime $createdDate
     */
    public function setCreatedDate(DateTime $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return int
     */
    public function getDeletedID(): int
    {
        return $this->deletedID;
    }

    /**
     * @param int $deletedID
     */
    public function setDeletedID(int $deletedID): void
    {
        $this->deletedID = $deletedID;
    }

    /**
     * @return string|null
     */
    public function getDeletedEmail(): ?string
    {
        return $this->deletedEmail;
    }

    /**
     * @param string|null $deletedEmail
     */
    public function setDeletedEmail(?string $deletedEmail): void
    {
        $this->deletedEmail = $deletedEmail;
    }

    /**
     * @return string|null
     */
    public function getDeletedName(): ?string
    {
        return $this->deletedName;
    }

    /**
     * @param string|null $deletedName
     */
    public function setDeletedName(?string $deletedName): void
    {
        $this->deletedName = $deletedName;
    }

    /**
     * @return DateTime|null
     */
    public function getDeletedDate(): ?DateTime
    {
        return $this->deletedDate;
    }

    /**
     * @param DateTime|null $deletedDate
     */
    public function setDeletedDate(?DateTime $deletedDate): void
    {
        $this->deletedDate = $deletedDate;
    }

    /**
     * @return int
     */
    public function getEventID(): int
    {
        return $this->eventID;
    }

    /**
     * @param int $eventID
     */
    public function setEventID(int $eventID): void
    {
        $this->eventID = $eventID;
    }

    /**
     * @return int
     */
    public function getTicketID(): int
    {
        return $this->ticketID;
    }

    /**
     * @param int $ticketID
     */
    public function setTicketID(int $ticketID): void
    {
        $this->ticketID = $ticketID;
    }

    /**
     * @return int
     */
    public function getParticipantID(): int
    {
        return $this->participantID;
    }

    /**
     * @param int $participantID
     */
    public function setParticipantID(int $participantID): void
    {
        $this->participantID = $participantID;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @param string|null $hash
     */
    public function setHash(?string $hash): void
    {
        $this->hash = $hash;
    }
}