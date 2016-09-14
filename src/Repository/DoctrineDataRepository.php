<?php
namespace DoctrineData\Repository;

use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\UnitOfWork;
use DoctrineData\Repository\Support\ConstructorSupport;
use DoctrineData\Repository\Support\PaginationSupport;
use DoctrineData\Repository\Support\QueryBuilderSupport;
use PhpCommonUtil\Util\Assert;

/**
 * 
 * @author Map
 *
 */
class DoctrineDataRepository implements  DoctrineDataRepositoryInterface
{

    use ConstructorSupport;
    use QueryBuilderSupport;
    use PaginationSupport;

    public function clear()
    {
        $this->_em->clear($this->_class->rootEntityName);
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->_em->find($this->_entityName, $id, $lockMode, $lockVersion);
    }

    public function findAll($pageableOrSort = null, int $hydrationMode = null)
    {

        if ( null === $pageableOrSort && null === $hydrationMode )
        {
            return $this->findBy(array());
        }

        $qb = $this->createQueryBuilder('e');

        if ( null === $pageableOrSort )
        {
            return $qb->getQuery()->getResult($hydrationMode);
        }
        else
        {
            return $this->processPageableOrSorting($qb, $pageableOrSort);
        }

    }

    public function findByIds(array $ids, int $hydrationMode){

        $qb = $this->createQueryBuilder('e');
        $identityFields = $this->_class->getIdentifier();
        Assert::isTrue(count($identityFields)==1, 'DoctrineSpringData Repository only support single primary key.');
        $idField = $identityFields[0];
        $qb->where("e.{$idField} IN (:ids)")->setParameter('ids', $ids);
        return $qb->getQuery()->getResult($hydrationMode);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }

     public function findOneBy(array $criteria, array $orderBy = null)
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return $persister->load($criteria, null, null, array(), null, 1, $orderBy);
    }

    /**
     * Adds support for magic finders.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return array|object The found entity/entities.
     *
     * @throws ORMException
     * @throws \BadMethodCallException If the method called is an invalid find* method
     *                                 or no find* method at all and therefore an invalid
     *                                 method call.
     */
    public function __call($method, $arguments)
    {
        switch (true) {
            case (0 === strpos($method, 'findBy')):
                $by = substr($method, 6);
                $method = 'findBy';
                break;

            case (0 === strpos($method, 'findOneBy')):
                $by = substr($method, 9);
                $method = 'findOneBy';
                break;

            default:
                throw new \BadMethodCallException(
                    "Undefined method '$method'. The method name must start with ".
                    "either findBy or findOneBy!"
                );
        }

        if (empty($arguments)) {
            throw ORMException::findByRequiresParameter($method . $by);
        }

        $fieldName = lcfirst(Inflector::classify($by));

        if ($this->_class->hasField($fieldName) || $this->_class->hasAssociation($fieldName)) {
            switch (count($arguments)) {
                case 1:
                    return $this->$method(array($fieldName => $arguments[0]));

                case 2:
                    return $this->$method(array($fieldName => $arguments[0]), $arguments[1]);

                case 3:
                    return $this->$method(array($fieldName => $arguments[0]), $arguments[1], $arguments[2]);

                case 4:
                    return $this->$method(array($fieldName => $arguments[0]), $arguments[1], $arguments[2], $arguments[3]);

                default:
                    // Do nothing
            }
        }

        throw ORMException::invalidFindByCall($this->_entityName, $fieldName, $method.$by);
    }


	public final function save($entity, bool $flush = false){

	    if (UnitOfWork::STATE_NEW === $this->_em->getUnitOfWork()->getEntityState($entity) ){
	        $this->_em->persist($entity);
	    }
	    else {
	        $entity = $this->_em->merge($entity);
	    }
	    
		if($flush){
			$this->_em->flush($entity);
		}	
		return $entity;
	}	
	

	public final function delete($entity, bool $flush=false){
	    
	    if(!$this->_em->contains($entity)){
	        $entity = $this->_em->merge($entity);
	    }
	    
	    $this->_em->remove($entity);
	    
	    if($flush){
	        $this->_em->flush();
	    }
	    return $entity;
	}		
	
	public final function getOne($id){
		return $this->_em->getReference($this->_entityName, $id);
	}


	



    /**
     * @return string
     */
    protected function getEntityName()
    {
        return $this->_entityName;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->getEntityName();
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->_em;
    }

    /**
     * @return ClassMetadata
     */
    protected function getClassMetadata()
    {
        return $this->_class;
    }

}

