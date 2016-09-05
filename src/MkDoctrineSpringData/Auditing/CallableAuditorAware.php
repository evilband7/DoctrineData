<?php
namespace MkDoctrineSpringData\Auditing;

class CallableAuditorAware implements AuditorAwareInterface
{
    
    private $callback;
    public function __construct(callable $callback){
        $this->callback = $callback;
    }
    public function getCurrentAuditor()
    {
        $callback = $this->callback;
        return call_user_func($callback);
    }

    
}

?>