<?php


namespace Futurolan\WeezeventBundle\Entity;


use JMS\Serializer\Annotation as Serializer;

/**
 * Class Buyer
 * @package Futurolan\WeezeventBundle\Entity
 */
class Buyer
{
    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id_acheteur;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $email_acheteur;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $acheteur_last_name;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $acheteur_first_name;

    /**
     * @var Answer[]
     * @Serializer\Type("array<Futurolan\WeezeventBundle\Entity\Answer>")
     */
    private $answers;


    /**
     * @return int
     */
    public function getIdAcheteur(): int
    {
        return $this->id_acheteur;
    }

    /**
     * @param int $id_acheteur
     */
    public function setIdAcheteur(int $id_acheteur): void
    {
        $this->id_acheteur = $id_acheteur;
    }

    /**
     * @return string
     */
    public function getEmailAcheteur(): string
    {
        return $this->email_acheteur;
    }

    /**
     * @param string $email_acheteur
     */
    public function setEmailAcheteur(string $email_acheteur): void
    {
        $this->email_acheteur = $email_acheteur;
    }

    /**
     * @return string
     */
    public function getAcheteurLastName(): string
    {
        return $this->acheteur_last_name;
    }

    /**
     * @param string $acheteur_last_name
     */
    public function setAcheteurLastName(string $acheteur_last_name): void
    {
        $this->acheteur_last_name = $acheteur_last_name;
    }

    /**
     * @return string
     */
    public function getAcheteurFirstName(): string
    {
        return $this->acheteur_first_name;
    }

    /**
     * @param string $acheteur_first_name
     */
    public function setAcheteurFirstName(string $acheteur_first_name): void
    {
        $this->acheteur_first_name = $acheteur_first_name;
    }

    /**
     * @return Answer[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param Answer[] $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }
}