<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/19/2016
 * Time: 4:57 AM
 */

namespace DoctrineData\Options;


use DoctrineData\Resolver\EntityResolver;
use Zend\Stdlib\AbstractOptions;

class ResolverOptions extends  AbstractOptions
{

    /**
     * @var int
     */
    private $priority;

    /**
     * @var EntityResolver
     */
    private $resolver;

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return EntityResolver
     */
    public function getResolver(): EntityResolver
    {
        return $this->resolver;
    }

    /**
     * @param EntityResolver $resolver
     */
    public function setResolver(EntityResolver $resolver)
    {
        $this->resolver = $resolver;
    }



}