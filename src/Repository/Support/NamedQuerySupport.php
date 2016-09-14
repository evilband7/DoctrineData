<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/06/2016
 * Time: 3:45 AM
 */

namespace DoctrineData\Repository\Support;


use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query;

trait NamedQuerySupport
{

    use ConstructorSupport;

    /**
     * Creates a new Query instance based on a predefined metadata named query.
     *
     * @param string $queryName
     *
     * @return Query
     */
    protected function createNamedQuery($queryName)
    {
        return $this->_em->createQuery($this->_class->getNamedQuery($queryName));
    }


    /**
     * Creates a native SQL query.
     *
     * @param string $queryName
     *
     * @return NativeQuery
     */
    protected function createNativeNamedQuery($queryName)
    {
        $queryMapping   = $this->_class->getNamedNativeQuery($queryName);
        $rsm            = new Query\ResultSetMappingBuilder($this->_em);
        $rsm->addNamedNativeQueryMapping($this->_class, $queryMapping);

        return $this->_em->createNativeQuery($queryMapping['query'], $rsm);
    }

}