<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    const ROLE_MAPPING = [
        'ROLE_SUPER_ADMIN' => "Super Admin",
        'ROLE_ADMIN' => "Admin",
        'ROLE_USER' => "User",
    ];

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $givenName;

    /**
     * @var string
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $familyName;

    /**
     * @var string
     * @ORM\Column(type="string", length=999, nullable=true)
     */
    private $pictureUrl;

    /**
     * @var string
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $locale;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank()
     */
    private $roles = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantee every user at least has ROLE_USER
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    /**
     * @param $roles
     * @return User
     */
    public function setRoles($roles): self
    {
        if ( is_null($roles) ) { $roles = []; }
        if ( is_string($roles) ) { $roles = [$roles]; }

        if (count($roles) > 1 && in_array('ROLE_SUPER_ADMIN', $roles) ) {$roles = ['ROLE_SUPER_ADMIN'];}
        if (count($roles) > 1 && in_array('ROLE_ADMIN', $roles) ) {$roles = ['ROLE_ADMIN'];}

        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * @param string $givenName
     * @return User
     */
    public function setGivenName(string $givenName): User
    {
        $this->givenName = $givenName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     * @return User
     */
    public function setFamilyName(string $familyName): User
    {
        $this->familyName = $familyName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    /**
     * @param string $pictureUrl
     * @return User
     */
    public function setPictureUrl(string $pictureUrl): User
    {
        $this->pictureUrl = $pictureUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return User
     */
    public function setLocale(string $locale): User
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return array
     */
    public function getReadableRoles(): array
    {
        $readableRoles = [];
        foreach($this->getRoles() as $role) {
            if ( key_exists($role, self::ROLE_MAPPING) ) {
                $readableRoles[] = self::ROLE_MAPPING[$role];
            }
        }
        return $readableRoles;
    }
}
