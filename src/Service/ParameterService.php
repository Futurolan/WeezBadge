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
    const API_KEY = 'apiKey';
    const API_TOKEN = 'apiToken';

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

        $value = $param->getValue();
        if ( count($value) === 1 && key_exists('value', $value) ) { $value = $value['value']; }
        return $value;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function set(string $name, $value)
    {
        $param = $this->em->getRepository(Parameter::class)->findOneBy(['name' => $name]);
        if (!$param instanceof Parameter) { $param = new Parameter(); }
        if ( !is_array($value) ) { $value = ['value' => $value]; }

        $param->setName($name);
        $param->setValue($value);

        $this->em->persist($param);
        $this->em->flush();
    }
}