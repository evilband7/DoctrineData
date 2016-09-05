<?php

namespace MkDoctrineSpringData\Domain;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractAuditable extends AbstractPersistable implements AuditableInterface{
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $createdDate;
	
	/**
	 * @ORM\ManyToOne(targetEntity=MK_DOCTRINE_SPRING_DATA\AUDITABLE\USER_CLASS)
	 * @ORM\JoinColumn(referencedColumnName=MK_DOCTRINE_SPRING_DATA\AUDITABLE\USER_ID)
	 */
	protected $createdBy;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $lastModifiedDate;
	
	/**
	 * @ORM\ManyToOne(targetEntity=MK_DOCTRINE_SPRING_DATA\AUDITABLE\USER_CLASS)
	 * @ORM\JoinColumn(referencedColumnName=MK_DOCTRINE_SPRING_DATA\AUDITABLE\USER_ID)
	 */
	protected $lastModifiedBy;
	
	
 /**
     * @return the $createdDate
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

 /**
     * @return the $createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

 /**
     * @return the $lastModifiedDate
     */
    public function getLastModifiedDate()
    {
        return $this->lastModifiedDate;
    }

 /**
     * @return the $lastModifiedBy
     */
    public function getLastModifiedBy()
    {
        return $this->lastModifiedBy;
    }

 /**
     * @param DateTime $createdDate
     */
    public function setCreatedDate(\DateTime $createdDate)
    {
        $this->createdDate = $createdDate;
    }

 /**
     * @param field_type $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

 /**
     * @param field_type $lastModifiedDate
     */
    public function setLastModifiedDate(\DateTime $lastModifiedDate)
    {
        $this->lastModifiedDate = $lastModifiedDate;
    }

 /**
     * @param field_type $lastModifiedBy
     */
    public function setLastModifiedBy($lastModifiedBy)
    {
        $this->lastModifiedBy = $lastModifiedBy;
    }


 
	

	
}