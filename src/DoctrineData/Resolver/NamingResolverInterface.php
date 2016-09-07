<?php
namespace DoctrineData\Resolver;

interface NamingResolverInterface
{
    function resolveEntityName($repositoryInterfaceName);
    function resolveRepositoryImplementationName($repositoryInterfaceName);
    function resolveRepositoryInterfaceName($entityName);
}

?>