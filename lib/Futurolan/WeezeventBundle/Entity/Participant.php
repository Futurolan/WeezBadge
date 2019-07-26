<?php


namespace Futurolan\WeezeventBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Participant
 * @package Futurolan\WeezeventBundle\Entity
 */
class Participant
{
    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id_participant;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id_event;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id_date;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id_ticket;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $barcode;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $id_weez_ticket;

    /**
     * @var bool
     * @Serializer\Type("bool")
     */
    private $deleted;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $refund;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $comment;

    /**
     * @var \DateTime
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private $create_date;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $origin;

    /**
     * @var int
     * @Serializer\Type("int")
     */
    private $id_transaction;

    /**
     * @var bool
     * @Serializer\Type("bool")
     */
    private $paid;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $code_member;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $transaction_reference;

    /**
     * @var ControlStatus
     * @Serializer\Type("Futurolan\WeezeventBundle\Entity\ControlStatus")
     */
    private $control_status;

    /**
     * @var string
     * @Serializer\Type("string")
     */
    private $promo_code;

    /**
     * @var Owner
     * @Serializer\Type("Futurolan\WeezeventBundle\Entity\Owner")
     */
    private $owner;

    /**
     * @var Answer[]
     * @Serializer\Type("array<Futurolan\WeezeventBundle\Entity\Answer>")
     */
    private $answers;

    /**
     * @return int
     */
    public function getIdParticipant(): int
    {
        return $this->id_participant;
    }

    /**
     * @return int
     */
    public function getIdEvent(): int
    {
        return $this->id_event;
    }

    /**
     * @return int
     */
    public function getIdDate(): int
    {
        return $this->id_date;
    }

    /**
     * @return int
     */
    public function getIdTicket(): int
    {
        return $this->id_ticket;
    }

    /**
     * @return int
     */
    public function getBarcode(): int
    {
        return $this->barcode;
    }

    /**
     * @return string
     */
    public function getIdWeezTicket(): string
    {
        return $this->id_weez_ticket;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @return string
     */
    public function getRefund(): string
    {
        return $this->refund;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate(): \DateTime
    {
        return $this->create_date;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * @return int
     */
    public function getIdTransaction(): int
    {
        return $this->id_transaction;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->paid;
    }

    /**
     * @return string
     */
    public function getCodeMember(): string
    {
        return $this->code_member;
    }

    /**
     * @return string
     */
    public function getTransactionReference(): string
    {
        return $this->transaction_reference;
    }

    /**
     * @return ControlStatus
     */
    public function getControlStatus(): ControlStatus
    {
        return $this->control_status;
    }

    /**
     * @return string
     */
    public function getPromoCode(): string
    {
        return $this->promo_code;
    }

    /**
     * @return Owner
     */
    public function getOwner(): Owner
    {
        return $this->owner;
    }

    /**
     * @return Answer[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }
}