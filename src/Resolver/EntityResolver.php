<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/18/2016
 * Time: 12:51 AM
 */

namespace DoctrineData\Resolver;


interface EntityResolver
{


    /**
     * @param \ReflectionClass $repositoryReflection
     * @return string
     */
    function resolve(\ReflectionClass $repositoryReflection) : string ;


    /**
     * @param \ReflectionClass $repositoryReflection
     * @param $repositoryName
     * @return bool true if able to resolve given repository
     */
    function support(\ReflectionClass $repositoryReflection) : bool ;

}