<?php
namespace DoctrineData\Domain\Driver;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class DomainDriver extends AnnotationDriver
{
    
    public function __construct($reader)
    {
        parent::__construct($reader, __DIR__.'/../');     
    }

    
    
}

?>