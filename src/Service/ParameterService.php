<?php


namespace App\Service;

use App\Entity\Parameter;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ParameterService
 * @package App\Service
 */
class ParameterService
{

    const DEFAULT_CATEGORY_NAME = 'DefaultCategory';

    /** @var EntityManagerInterface */
    private $em;

    /**
     * ParameterService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        $param = $this->em->getRepository(Parameter::class)->findOneBy(['name' => $name]);
        if ( !$param instanceof Parameter) { return null; }
        return $param->getValue();
    }

    public function set(string $name, ?array $value)
    {
        $param = $this->em->getRepository(Parameter::class)->findOneBy(['name' => $name]);
        if (!$param instanceof Parameter) { $param = new Parameter(); }
        $param->setName($name);
        $param->setValue($value);

        $this->em->persist($param);
        $this->em->flush();
    }
}