<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/06/2016
 * Time: 3:17 AM
 */

namespace DoctrineData\Repository;


use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\LazyCriteriaCollection;
use DoctrineData\Repository\Support\ConstructorSupport;

trait SelectableSupportTraits
{

    use ConstructorSupport;

    /**
     * Select all elements from a selectable that match the expression and
     * return a new collection containing these elements.
     *
     * @param Criteria $criteria
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function matching(Criteria $criteria)
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return new LazyCriteriaCollection($persister, $criteria);
    }

}