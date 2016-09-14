<?php
namespace DoctrineData\Factory;

use Doctrine\ORM\Repository\RepositoryFactory as DoctrineRepositoryFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use DoctrineData\Repository\DoctrineDataRepository;
use DoctrineData\Context\ContextInterface;

class RepositoryFactory implements DoctrineRepositoryFactoryInterface
{
    
    /**
     * @var ContextInterface
     */
    private $context;
    
    public function __construct(ContextInterface $context){
        $this->context = $context;
    }
    
    public function getRepository(\Doctrine\ORM\EntityManagerInterface $entityManager, $entityName)
    {
        return $this->context->getRepository($entityManager, $entityName);
    }
    
}
?>