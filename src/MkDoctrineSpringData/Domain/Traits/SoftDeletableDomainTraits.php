<?php
namespace MkDoctrineSpringData\Domain\Traits;
use Doctrine\ORM\Mapping as ORM;

trait SoftDeletableDomainTraits {
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted;
    
    /**
     * @return the $isDeleted
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param field_type $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }

    
    
}

?>