<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Answer
 * @package Futurolan\WeezeventBundle\Entity
 */
class Answer
{
    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $label;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $value;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}