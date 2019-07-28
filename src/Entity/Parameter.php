<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Parameter
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ParameterRepository")
 * @UniqueEntity("name")
 */
class Parameter
{
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
     */
    private $name;

    /**
     * @var null|array
     * @ORM\Column(type="json")
     */
    private $value;

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
     * @return array|null
     */
    public function getValue(): ?array
    {
        return $this->value;
    }

    /**
     * @param array|null $value
     */
    public function setValue(?array $value): void
    {
        $this->value = $value;
    }
}