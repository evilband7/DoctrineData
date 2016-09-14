<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/06/2016
 * Time: 3:39 AM
 */

namespace DoctrineData\Repository\Support;


use Doctrine\ORM\QueryBuilder;

trait QueryBuilderSupport
{

    use ConstructorSupport;

    /**
     * Creates a new QueryBuilder instance that is pre-populated for this entity name.
     *
     * @param string $alias
     * @param string $indexBy The index for the from.
     *
     * @return QueryBuilder
     */
    protected function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->_em->createQueryBuilder()
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy);
    }

}