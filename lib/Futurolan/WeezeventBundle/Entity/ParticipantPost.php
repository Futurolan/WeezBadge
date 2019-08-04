<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ParticipantPost
 * @package Futurolan\WeezeventBundle\Entity
 */
class ParticipantPost
{
    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id_evenement;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id_billet;

    /**
     * @var string|null
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @var string|null
     * @Serializer\Type("string")
     */
    private $nom;

    /**
     * @var string|null
     * @Serializer\Type("string")
     */
    private $prenom;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $barcode_id;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $barcode_pairing_id;

    /**
     * @var bool
     * @Serializer\Type("bool")
     */
    private $notify;

    /**
     * @var ParticipantForm|null
     * @Serializer\Type("Futurolan\WeezeventBundle\Entity\ParticipantForm")
     */
    private $form;

    /**
     * @return int
     */
    public function getIdEvenement(): int
    {
        return $this->id_evenement;
    }

    /**
     * @param int $id_evenement
     */
    public function setIdEvenement(int $id_evenement): void
    {
        $this->id_evenement = $id_evenement;
    }

    /**
     * @return int
     */
    public function getIdBillet(): int
    {
        return $this->id_billet;
    }

    /**
     * @param int $id_billet
     */
    public function setIdBillet(int $id_billet): void
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
     * @param string $email
     */
    public function setEmail(string $email): void
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
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return int
     */
    public function getBarcodeId(): int
    {
        return $this->barcode_id;
    }

    /**
     * @param int $barcode_id
     */
    public function setBarcodeId(int $barcode_id): void
    {
        $this->barcode_id = $barcode_id;
    }

    /**
     * @return string
     */
    public function getBarcodePairingId(): string
    {
        return $this->barcode_pairing_id;
    }

    /**
     * @param string $barcode_pairing_id
     */
    public function setBarcodePairingId(string $barcode_pairing_id): void
    {
        $this->barcode_pairing_id = $barcode_pairing_id;
    }

    /**
     * @return ParticipantForm|null
     */
    public function getForm(): ?ParticipantForm
    {
        return $this->form;
    }

    /**
     * @param ParticipantForm|null $form
     */
    public function setForm(?ParticipantForm $form): void
    {
        $this->form = $form;
    }

    /**
     * @return bool
     */
    public function isNotify(): bool
    {
        return $this->notify;
    }

    /**
     * @param bool $notify
     */
    public function setNotify(bool $notify): void
    {
        $this->notify = $notify;
    }
}