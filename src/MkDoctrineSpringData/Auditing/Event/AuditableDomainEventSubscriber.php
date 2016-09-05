<?php
namespace MkDoctrineSpringData\Auditing\Event;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use MkDoctrineSpringData\Domain\AuditableInterface;
use MkDoctrineSpringData\Auditing\AuditorAwareInterface;

class AuditableDomainEventSubscriber implements EventSubscriber
{
    
    /**
     * @var AuditorAwareInterface
     */
    private $auditorAware;
    
    /**
     * 
     * @var LoggerInterface
     */
    private $logger;
    
    public function __construct(AuditorAwareInterface $auditorAware, LoggerInterface $logger){
        $this->auditorAware = $auditorAware;
        $this->logger = $logger;
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $target = $args->getEntity();
        if($target instanceof  AuditableInterface){
            
            /* @var $toAudit AuditableInterface  */
            $toAudit            = $target;
            $auditor            = $this->auditorAware->getCurrentAuditor();
            $currentDateTime    = new \DateTime();
            
            $toAudit->setCreatedDate($currentDateTime);
            $toAudit->setCreatedBy($auditor);
            
            $auditor = $auditor? $auditor : '`unknow`';
            $this->logger->debug(sprintf('Touched %s - Created at %s by %s', $target->__toString(), $currentDateTime->format('Y-m-d H:i:s'), $auditor));
        }
    }
    
    public function preUpdate(LifecycleEventArgs $args)
    {
        $target = $args->getEntity();
        if($target instanceof  AuditableInterface){
            
            /* @var $toAudit AuditableInterface  */
            $toAudit            = $target;
            $auditor            = $this->auditorAware->getCurrentAuditor();
            $currentDateTime    = new \DateTime();
            
            $toAudit->setLastModifiedDate($currentDateTime);
            $toAudit->setLastModifiedBy($auditor);
            
            $auditor = $auditor? $auditor : '`unknow`';
            $this->logger->debug(sprintf('Touched %s - Last modification at %s by %s', $target, $currentDateTime->format('Y-m-d H:i:s'), $auditor));
        }
    }

    public function getSubscribedEvents()
    {
        return array( Events::prePersist, Events::preUpdate );
    }
}