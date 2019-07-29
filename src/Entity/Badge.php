<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Badge
{
    /**
     * @var int|null
     */
    private $id_evenement;

    /**
     * @var int|null
     */
    private $id_billet;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private $prenom;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private $societe;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private $fonction;

    /**
     * @var bool|null
     */
    private $notify;

    /**
     * @return int|null
     */
    public function getIdEvenement(): ?int
    {
        return $this->id_evenement;
    }

    /**
     * @param int|null $id_evenement
     */
    public function setIdEvenement(?int $id_evenement): void
    {
        $this->id_evenement = $id_evenement;
    }

    /**
     * @return int|null
     */
    public function getIdBillet(): ?int
    {
        return $this->id_billet;
    }

    /**
     * @param int|null $id_billet
     */
    public function setIdBillet(?int $id_billet): void
    {
        $this->id_billet = $id_billet;
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
}