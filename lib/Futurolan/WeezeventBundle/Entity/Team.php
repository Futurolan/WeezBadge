<?php


namespace Futurolan\WeezeventBundle\Entity;


class Team
{
    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var string */
    private $ownerLastName;

    /** @var string */
    private $ownerFirstName;

    /** @var Participant[] */
    private $members = [];

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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getOwnerLastName(): string
    {
        return $this->ownerLastName;
    }

    /**
     * @param string $ownerLastName
     */
    public function setOwnerLastName(string $ownerLastName): void
    {
        $this->ownerLastName = $ownerLastName;
    }

    /**
     * @return string
     */
    public function getOwnerFirstName(): string
    {
        return $this->ownerFirstName;
    }

    /**
     * @param string $ownerFirstName
     */
    public function setOwnerFirstName(string $ownerFirstName): void
    {
        $this->ownerFirstName = $ownerFirstName;
    }

    /**
     * @return Participant[]
     */
    public function getMembers(): array
    {
        return $this->members;
    }

    /**
     * @param Participant[] $members
     */
    public function setMembers(array $members): void
    {
        $this->members = $members;
    }

    /**
     * @param Participant $participant
     */
    public function addMember(Participant $participant): void
    {
        $this->members[] = $participant;
    }
}