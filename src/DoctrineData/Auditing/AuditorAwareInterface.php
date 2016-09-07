<?php
namespace DoctrineData\Auditing;

interface AuditorAwareInterface
{
    function getCurrentAuditor();
}

?>