<?php
namespace DoctrineData\Domain\Driver;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
class DomainDriver extends com
{
    
    public function __construct($reader, $paths = null)
    {
        parent::__construct($reader, __DIR__.'/../');     
    }

    
    
}

?>