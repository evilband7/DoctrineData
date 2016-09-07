<?php
namespace DoctrineData\Domain;

interface AuditableInterface extends PersistableInterface
{
    function getCreatedBy();
    function setCreatedBy($createdBy);
    
    function getCreatedDate();
    function setCreatedDate(\DateTime $createdDate);
    
    function getLastModifiedBy();
    function setLastModifiedBy($lastModifiedBy);
    
    function getLastModifiedDate();
    function setLastModifiedDate(\DateTime $lastModifiedDate);
    
}

?>