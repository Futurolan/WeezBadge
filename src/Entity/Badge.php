<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class Badge
{
    /**
     * @var int|null
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     * @Serializer\Type("int")
     */
    private $eventID;

    /**
     * @var int|null
     * @Assert\NotBlank
     * @Assert\GreaterThan(
     *     value = 0,
     *     message = "Le type de badge doit être défini."
     * )
     * @Serializer\Type("int")
     */
    private $ticketID;

    /**
     * @var string|null
     * @Assert\NotBlank(message="L'adresse email ne peut être vide.")
     * @Assert\Email(message="L'adresse email est invalide.")
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Le nom ne peut être vide.")
     * @Serializer\Type("string")
     */
    private $nom;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Le prénom ne peut être vide.")
     * @Serializer\Type("string")
     */
    private $prenom;

    /**
     * @var string|null
     * @Serializer\Type("string")
     */
    private $pseudo;

    /**
     * @var string|null
     * @Serializer\Type("string")
     */
    private $societe;

    /**
     * @var string|null
     * @Serializer\Type("string")
     */
    private $fonction;

    /**
     * @var bool|null
     * @Serializer\Type("bool")
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string|null $prenom
     */
    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string|null
     */
    public function getSociete(): ?string
    {
        return $this->societe;
    }

    /**
     * @param string|null $societe
     */
    public function setSociete(?string $societe): void
    {
        $this->societe = $societe;
    }

    /**
     * @return string|null
     */
    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    /**
     * @param string|null $fonction
     */
    public function setFonction(?string $fonction): void
    {
        $this->fonction = $fonction;
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

    /**
     * @return string|null
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * @param string|null $pseudo
     */
    public function setPseudo(?string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        $badge = [
            $this->getEventID(),
            $this->getNom(),
            $this->getPrenom(),
            $this->getEmail()
        ];
        $badge = array_map('trim', $badge);
        $badge = array_map('strtolower', $badge);
        return hash('sha256', implode(',', $badge));
    }
}