<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Owner
 * @package Futurolan\WeezeventBundle\Entity
 */
class Owner
{
    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $first_name;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $last_name;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $comment;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $custom_field;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $origin;

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getCustomField(): string
    {
        return $this->custom_field;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }
}