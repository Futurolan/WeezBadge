<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;
use \DateTime;

/**
 * Class ControlStatus
 * @package Futurolan\WeezeventBundle\Entity
 */
class ControlStatus
{
    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $status;

    /**
     * @var \DateTime|null
     * @Serializer\Type("string")
     * @Serializer\Accessor(getter="getScanDate",setter="setScanDateFromString")
     */
    private $scan_date;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $scan_user;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $scan_user_name;

    /**
     * @param string $scan_date
     */
    public function setScanDateFromString(string $scan_date)
    {
        if (empty($scan_date) || $scan_date == "0000-00-00 00:00:00") {
            $this->scan_date = null;
        } else {
            $this->scan_date = DateTime::createFromFormat('Y-m-d H:i:s', $scan_date);
        }
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return DateTime|null
     */
    public function getScanDate(): ?DateTime
    {
        return $this->scan_date;
    }

    /**
     * @return int
     */
    public function getScanUser(): int
    {
        return $this->scan_user;
    }

    /**
     * @return string
     */
    public function getScanUserName(): string
    {
        return $this->scan_user_name;
    }

}