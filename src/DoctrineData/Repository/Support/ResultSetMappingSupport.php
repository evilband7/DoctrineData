<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/06/2016
 * Time: 3:46 AM
 */

namespace DoctrineData\Repository\Support;


use Doctrine\ORM\Query\ResultSetMappingBuilder;

trait ResultSetMappingSupport
{
    use ConstructorSupport;


    /**
     * Creates a new result set mapping builder for this entity.
     *
     * The column naming strategy is "INCREMENT".
     *
     * @param string $alias
     *
     * @return ResultSetMappingBuilder
     */
    protected function createResultSetMappingBuilder($alias)
    {
        $rsm = new ResultSetMappingBuilder($this->_em, ResultSetMappingBuilder::COLUMN_RENAMING_INCREMENT);
        $rsm->addRootEntityFromClassMetadata($this->_entityName, $alias);

        return $rsm;
    }


}