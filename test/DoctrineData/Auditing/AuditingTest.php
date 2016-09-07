<?php
namespace DoctrineData\Auditing;

use DoctrineData\Auditing\Event\AuditableDomainEventSubscriber;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Doctrine\ORM\Event\LifecycleEventArgs;
use DoctrineData\Domain\AuditableInterface;
class AuditingTest extends \PHPUnit_Framework_TestCase
{
    
    public function testCallableAuditorAware(){
        $expectedAuditor = 'testAuditor';
        $auditorAware = $this->createAuditorAware($expectedAuditor);
        $this->assertEquals($expectedAuditor, $auditorAware->getCurrentAuditor());
    }
    
    private function createAuditorAware($auditorName){
        $auditorAware = new CallableAuditorAware(function() use ($auditorName){
            return $auditorName;
        });
        return $auditorAware;
    }
    
    private function createLogger(){
        $logger = new Logger('AuditingTestLogger');
        $logger->pushHandler(new StreamHandler(__DIR__.'/../../log/audting-test.log'));
        return $logger;
    }
    public function testAuditSubscriber(){
        $auditorAware = $this->createAuditorAware('`someUser`');
        $logger = $this->createLogger();
        $logger->debug('Start audit subscriber test...');
        $subscriber = new AuditableDomainEventSubscriber($auditorAware, $logger);

        $emMock = $this->getMock('\Doctrine\ORM\EntityManagerInterface');
//         $auditableMock = $this->getMockBuilder('\DoctrineData\Domain\AuditableInterface')->setMethods(['__toString'=>null, 'getCreatedBy'=>null, 'setCreatedBy'=>null, 'getCreatedDate'=>null, 'setCreatedDate'=>null,'getLastModifiedDate'=>null, 'setLastModifiedDate'=>null, 'getLastModifiedBy'=>null, 'setLastModifiedBy'=>null, 'getId'=>null])->getMock();
        $auditableMock = new AuditableMock();
        $args = new  \Doctrine\ORM\Event\LifecycleEventArgs($auditableMock, $emMock);
        
        $subscriber->prePersist($args);
        $subscriber->preUpdate($args);
        $logger->debug((string) $auditableMock->getCreatedDate());
        
        $logger->debug(\test\TEST);
    }
}

class AuditableMock implements AuditableInterface{
    public function getCreatedBy()
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \DoctrineData\Domain\AuditableInterface::getCreatedDate()
     */
    public function getCreatedDate()
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \DoctrineData\Domain\AuditableInterface::getLastModifiedBy()
     */
    public function getLastModifiedBy()
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \DoctrineData\Domain\AuditableInterface::getLastModifiedDate()
     */
    public function getLastModifiedDate()
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \DoctrineData\Domain\AuditableInterface::setCreatedBy()
     */
    public function setCreatedBy($createdBy)
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \DoctrineData\Domain\AuditableInterface::setCreatedDate()
     */
    public function setCreatedDate(\DateTime $createdDate)
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \DoctrineData\Domain\AuditableInterface::setLastModifiedBy()
     */
    public function setLastModifiedBy($lastModifiedBy)
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \DoctrineData\Domain\AuditableInterface::setLastModifiedDate()
     */
    public function setLastModifiedDate(\DateTime $lastModifiedDate)
    {
        // TODO Auto-generated method stub
        
    }

 /* (non-PHPdoc)
     * @see \DoctrineData\Domain\PersistableInterface::getId()
     */
    public function getId()
    {
        // TODO Auto-generated method stub
        
    }

    public function __toString(){
        return '`entity`';
    }
}

include __DIR__. '/constant.php';
?>