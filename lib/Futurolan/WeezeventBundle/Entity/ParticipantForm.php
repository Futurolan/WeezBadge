<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ParticipantForm
 * @package Futurolan\WeezeventBundle\Entity
 */
class ParticipantForm
{
    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $adresse;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $adressedelivraison;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $adresse_societe;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $billet_prix;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $blog;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $choix_place;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $civilite;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $codepostaldelivraison;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $code_postal;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $code_postal_societe;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $commentaires;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $date_de_naissance;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $email_pro;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $fonction;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $nom;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $pays;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $paysdelivraison;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $pays_societe;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $portable;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $portable_societe;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $prenom;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $site_internet;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $societe;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $telephone;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $validity_date_start;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $ville;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $villedelivraison;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $ville_societe;

    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getAdressedelivraison(): string
    {
        return $this->adressedelivraison;
    }

    /**
     * @param string $adressedelivraison
     */
    public function setAdressedelivraison(string $adressedelivraison): void
    {
        $this->adressedelivraison = $adressedelivraison;
    }

    /**
     * @return string
     */
    public function getAdresseSociete(): string
    {
        return $this->adresse_societe;
    }

    /**
     * @param string $adresse_societe
     */
    public function setAdresseSociete(string $adresse_societe): void
    {
        $this->adresse_societe = $adresse_societe;
    }

    /**
     * @return string
     */
    public function getBilletPrix(): string
    {
        return $this->billet_prix;
    }

    /**
     * @param string $billet_prix
     */
    public function setBilletPrix(string $billet_prix): void
    {
        $this->billet_prix = $billet_prix;
    }

    /**
     * @return string
     */
    public function getBlog(): string
    {
        return $this->blog;
    }

    /**
     * @param string $blog
     */
    public function setBlog(string $blog): void
    {
        $this->blog = $blog;
    }

    /**
     * @return string
     */
    public function getChoixPlace(): string
    {
        return $this->choix_place;
    }

    /**
     * @param string $choix_place
     */
    public function setChoixPlace(string $choix_place): void
    {
        $this->choix_place = $choix_place;
    }

    /**
     * @return string
     */
    public function getCivilite(): string
    {
        return $this->civilite;
    }

    /**
     * @param string $civilite
     */
    public function setCivilite(string $civilite): void
    {
        $this->civilite = $civilite;
    }

    /**
     * @return string
     */
    public function getCodepostaldelivraison(): string
    {
        return $this->codepostaldelivraison;
    }

    /**
     * @param string $codepostaldelivraison
     */
    public function setCodepostaldelivraison(string $codepostaldelivraison): void
    {
        $this->codepostaldelivraison = $codepostaldelivraison;
    }

    /**
     * @return string
     */
    public function getCodePostal(): string
    {
        return $this->code_postal;
    }

    /**
     * @param string $code_postal
     */
    public function setCodePostal(string $code_postal): void
    {
        $this->code_postal = $code_postal;
    }

    /**
     * @return string
     */
    public function getCodePostalSociete(): string
    {
        return $this->code_postal_societe;
    }

    /**
     * @param string $code_postal_societe
     */
    public function setCodePostalSociete(string $code_postal_societe): void
    {
        $this->code_postal_societe = $code_postal_societe;
    }

    /**
     * @return string
     */
    public function getCommentaires(): string
    {
        return $this->commentaires;
    }

    /**
     * @param string $commentaires
     */
    public function setCommentaires(string $commentaires): void
    {
        $this->commentaires = $commentaires;
    }

    /**
     * @return string
     */
    public function getDateDeNaissance(): string
    {
        return $this->date_de_naissance;
    }

    /**
     * @param string $date_de_naissance
     */
    public function setDateDeNaissance(string $date_de_naissance): void
    {
        $this->date_de_naissance = $date_de_naissance;
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
    public function getEmailPro(): string
    {
        return $this->email_pro;
    }

    /**
     * @param string $email_pro
     */
    public function setEmailPro(string $email_pro): void
    {
        $this->email_pro = $email_pro;
    }

    /**
     * @return string
     */
    public function getFonction(): string
    {
        return $this->fonction;
    }

    /**
     * @param string $fonction
     */
    public function setFonction(string $fonction): void
    {
        $this->fonction = $fonction;
    }

    /**
     * @return string
     */
    public function getNom(): string
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
    public function getPays(): string
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays(string $pays): void
    {
        $this->pays = $pays;
    }

    /**
     * @return string
     */
    public function getPaysdelivraison(): string
    {
        return $this->paysdelivraison;
    }

    /**
     * @param string $paysdelivraison
     */
    public function setPaysdelivraison(string $paysdelivraison): void
    {
        $this->paysdelivraison = $paysdelivraison;
    }

    /**
     * @return string
     */
    public function getPaysSociete(): string
    {
        return $this->pays_societe;
    }

    /**
     * @param string $pays_societe
     */
    public function setPaysSociete(string $pays_societe): void
    {
        $this->pays_societe = $pays_societe;
    }

    /**
     * @return string
     */
    public function getPortable(): string
    {
        return $this->portable;
    }

    /**
     * @param string $portable
     */
    public function setPortable(string $portable): void
    {
        $this->portable = $portable;
    }

    /**
     * @return string
     */
    public function getPortableSociete(): string
    {
        return $this->portable_societe;
    }

    /**
     * @param string $portable_societe
     */
    public function setPortableSociete(string $portable_societe): void
    {
        $this->portable_societe = $portable_societe;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
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
     * @return string
     */
    public function getSiteInternet(): string
    {
        return $this->site_internet;
    }

    /**
     * @param string $site_internet
     */
    public function setSiteInternet(string $site_internet): void
    {
        $this->site_internet = $site_internet;
    }

    /**
     * @return string
     */
    public function getSociete(): string
    {
        return $this->societe;
    }

    /**
     * @param string $societe
     */
    public function setSociete(string $societe): void
    {
        $this->societe = $societe;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getValidityDateStart(): string
    {
        return $this->validity_date_start;
    }

    /**
     * @param string $validity_date_start
     */
    public function setValidityDateStart(string $validity_date_start): void
    {
        $this->validity_date_start = $validity_date_start;
    }

    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getVilledelivraison(): string
    {
        return $this->villedelivraison;
    }

    /**
     * @param string $villedelivraison
     */
    public function setVilledelivraison(string $villedelivraison): void
    {
        $this->villedelivraison = $villedelivraison;
    }

    /**
     * @return string
     */
    public function getVilleSociete(): string
    {
        return $this->ville_societe;
    }

    /**
     * @param string $ville_societe
     */
    public function setVilleSociete(string $ville_societe): void
    {
        $this->ville_societe = $ville_societe;
    }
}