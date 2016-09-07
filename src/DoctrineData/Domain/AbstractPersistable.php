<?php

namespace DoctrineData\Domain;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractPersistable implements PersistableInterface{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString(){
        $clazz = get_class($this);
        return "Entity of type {$clazz} with id: {$this->getId()}";
    }
	
}