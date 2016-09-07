<?php
namespace DoctrineData\Repository;

use Doctrine\ORM\ORMException;
use DoctrineData\Pagination\PageableInterface;
use DoctrineData\Pagination\PageInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineData\Pagination\Sort;

interface DoctrineDataRepositoryInterface extends ObjectRepository
{
    
    /**
     * Save target entity into db.
     * @param object $entity Entity to save
     * @param bool $flush flag to flush after save or not 
     */
    function save($entity, bool $flush = false);
    
    /**
     * delete target entity
     * @param object $entity 
     * @param boolean $flush
     */
    function delete($entity, bool $flush=false);
    
    /**
     * @see \Doctrine\ORM\EntityRepository::clear()
     */
    function clear();

    /**
     * Gets a reference to the entity identified by the given type and identifier
     * without actually loading it, if the entity is not yet loaded.
     *
     * @param mixed  $id         The entity identifier.     *
     * @return object The entity reference.     *
     * @throws ORMException
     */
    function getOne($id);
    
    /**
     * Finds all objects in the repository.
     * @param PageableInterface|Sort $pageableOrSort Sort if you wanna define sorting or PageableInterface if you wanna do pagination and null if you want to find all entities.
     * @param int $hydrationMode DoctrineQuery HydrationMode.
     * @return PageInterface|array
     */
    function findAll($pageableOrSort = null, int $hydrationMode = null);


    function findByIds(array $ids, int $hydrationMode);
    
    /**
     * @see \Doctrine\ORM\EntityRepository::getClassName()
     */
    function getClassName();
    

}

?>