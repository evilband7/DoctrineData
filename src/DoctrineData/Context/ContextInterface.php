<?php
namespace DoctrineData\Context;

interface ContextInterface
{
//     function initialize();
    
    function getRepository(\Doctrine\ORM\EntityManagerInterface $entityManager, $entityName);
    
}

?>