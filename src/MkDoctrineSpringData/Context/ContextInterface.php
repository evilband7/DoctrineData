<?php
namespace MkDoctrineSpringData\Context;

interface ContextInterface
{
//     function initialize();
    
    function getRepository(\Doctrine\ORM\EntityManagerInterface $entityManager, $entityName);
    
}

?>