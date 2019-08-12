<?php


namespace App\Entity;

/**
 * Class Acl
 * @package App\Entity
 */
class Acl
{
    /** @var array */
    private $allowedTickets = [];

    /** @var int */
    private $eventId;

    /**
     * @return array
     */
    public function getAllowedTickets(): array
    {
        return $this->allowedTickets;
    }

    /**
     * @param array $allowedTickets
     */
    public function setAllowedTickets(array $allowedTickets): void
    {
        $this->allowedTickets = $allowedTickets;
    }

    /**
     * @param int $ticketId
     */
    public function addAllowedTIckets(int $ticketId): void
    {
        $this->allowedTickets[] = $ticketId;
    }

    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }

    /**
     * @param int $eventId
     */
    public function setEventId(int $eventId): void
    {
        $this->eventId = $eventId;
    }

    /**
     * @param array|null $roles
     */
    public function rolesToAcl(?array $roles): void
    {
        dump($roles);
        if (is_array($roles) ) {
            foreach($roles as $role) {
                if ( preg_match('/^ROLE_(?<eventId>\d+)_(?<ticketId>\d+)$/', $role, $matches) ) {
                    dump($matches);
                    if ( (int)$matches['eventId'] === $this->getEventId() ) {
                        $this->addAllowedTIckets($matches['ticketId']);
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function aclToRoles(): array
    {
        $res = [];
        foreach($this->getAllowedTickets() as $ticketId) {
            $res[] = 'ROLE_'.$this->getEventId().'_'.$ticketId;
        }
        return $res;
    }
}