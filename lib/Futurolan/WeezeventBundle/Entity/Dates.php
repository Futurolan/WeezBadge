<?php


namespace Futurolan\WeezeventBundle\Entity;

use \DateTime;
use JMS\Serializer\Annotation as Serializer;

class Dates
{
    /**
     * @var DateTime|null
     * @Serializer\Type("string")
     * @Serializer\Accessor(getter="getStart",setter="setStartFromString")
     */
    private $start;

    /**
     * @var DateTime|null
     * @Serializer\Type("string")
     * @Serializer\Accessor(getter="getEnd",setter="setEndFromString")
     */
    private $end;

    /**
     * @return DateTime|null
     */
    public function getStart(): ?DateTime
    {
        return $this->start;
    }

    /**
     * @param DateTime|null $start
     */
    public function setStart(?DateTime $start): void
    {
        $this->start = $start;
    }

    /**
     * @param string $start
     */
    public function setStartFromString(string $start)
    {
        if (empty($start)) {
            $this->start = null;
        } else {
            $this->start = DateTime::createFromFormat('Y-m-d H:i:s', $start);
        }
    }

    /**
     * @return DateTime|null
     */
    public function getEnd(): ?DateTime
    {
        return $this->end;
    }

    /**
     * @param DateTime|null $end
     */
    public function setEnd(?DateTime $end): void
    {
        $this->end = $end;
    }

    /**
     * @param string $end
     */
    public function setEndFromString(string $end)
    {
        if (empty($end)) {
            $this->end = null;
        } else {
            $this->end = DateTime::createFromFormat('Y-m-d H:i:s', $end);
        }
    }
}