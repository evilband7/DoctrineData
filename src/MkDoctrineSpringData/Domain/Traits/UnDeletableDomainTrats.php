<?php
namespace MkDoctrineSpringData\Domain\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Make sure your entity has LifeCycleCallbacks.
 *
 */
trait UnDeletableDomainTrats {
    
    /**
     * @ORM\PreRemove
     */
    public function preDelete(){
        throw new \InvalidArgumentException('Unable to delete this item: ' . $this->__toString() );
    }
    
}

?>