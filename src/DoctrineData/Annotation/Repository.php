<?php
namespace DoctrineData\Annotation;

/**
 * @Annotation
 *
 */
class Repository
{
    
    private $entityName;

    /**
     * @return mixed
     */
    public function getEntityName()
    {
        return $this->entityName;
    }


    
}

?>