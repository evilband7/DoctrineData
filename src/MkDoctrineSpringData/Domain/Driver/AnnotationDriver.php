<?php
namespace MkDoctrineSpringData\Domain\Driver;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
class DomainDriver extends AnnotationDriver
{
    
    public function __construct($reader, $paths = null)
    {
        parent::__construct($reader, __DIR__.'/../');     
    }

    
    
}

?>