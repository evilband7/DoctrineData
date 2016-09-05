<?php
namespace MkDoctrineSpringData\Factory;

use Doctrine\ORM\Repository\RepositoryFactory as DoctrineRepositoryFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use MkDoctrineSpringData\Repository\BaseRepositoryImpl;
use MkDoctrineSpringData\Context\ContextInterface;

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