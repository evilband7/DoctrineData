<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/06/2016
 * Time: 3:37 AM
 */

namespace DoctrineData\Repository\Support;


use PhpCommonUtil\Util\Assert;

trait MinMaxIdExtractionSupport
{
    use QueryBuilderSupport;

    public function findMinId(){
        $idField = $this->assertPkIsNotCompositeAndIsNumber();
        $this->createQueryBuilder('e')->resetDQLPart('select')->select('min(e.'.$idField.')')->getQuery()->getSingleScalarResult();
    }

    public function findMaxId(){
        $idField = $this->assertPkIsNotCompositeAndIsNumber();
        $this->createQueryBuilder('e')->resetDQLPart('select')->select('max(e.'.$idField.')')->getQuery()->getSingleScalarResult();
    }

    protected function assertPkIsNotCompositeAndIsNumber(){
        $identityFields = $this->_class->getIdentifier();
        Assert::isTrue(count($identityFields)==1, 'DoctrineSpringData Repository only support single primary key.');
        $type = $this->_class->getTypeOfField($identityFields[0]);
        Assert::isTrue(in_array($type, ['bigint','decimal','integer','smallint','float']));
        return $identityFields[0];
    }

}