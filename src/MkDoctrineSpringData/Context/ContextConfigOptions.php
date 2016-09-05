<?php
namespace MkDoctrineSpringData\Context;

use Zend\Stdlib\AbstractOptions;

class ContextConfigOptions extends AbstractOptions
{
    
    private $repositoryDirectories = [];
    private $repositoryInterfacePostfix;
    private $repositoryImplPostfix;
    
    
 /**
     * @return the $repositoryDirectories
     */
    public function getRepositoryDirectories()
    {
        return $this->repositoryDirectories;
    }

 /**
     * @return the $repositoryInterfacePostfix
     */
    public function getRepositoryInterfacePostfix()
    {
        return $this->repositoryInterfacePostfix;
    }

 /**
     * @return the $repositoryImplPostfix
     */
    public function getRepositoryImplPostfix()
    {
        return $this->repositoryImplPostfix;
    }

 /**
     * @param multitype: $repositoryDirectories
     */
    public function setRepositoryDirectories($repositoryDirectories)
    {
        $this->repositoryDirectories = $repositoryDirectories;
    }

 /**
     * @param field_type $repositoryInterfacePostfix
     */
    public function setRepositoryInterfacePostfix($repositoryInterfacePostfix)
    {
        $this->repositoryInterfacePostfix = $repositoryInterfacePostfix;
    }

 /**
     * @param field_type $repositoryImplPostfix
     */
    public function setRepositoryImplPostfix($repositoryImplPostfix)
    {
        $this->repositoryImplPostfix = $repositoryImplPostfix;
    }

    



    
    
    
    
    
}

?>