<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/18/2016
 * Time: 1:03 AM
 */

namespace DoctrineData\Resolver;


use PhpCommonUtil\Util\StringUtils;

class SimpleEntityResolver implements  EntityResolver
{

    private $namespaceKeywordFrom;
    private $namespaceKeywordTo;
    private $classKeywordFrom;
    private $classKeywordTo;

    /**
     * SimpleResolver constructor.
     * @param $namespaceKeywordFrom
     * @param $namespaceKeywordTo
     * @param $classKeywordFrom
     * @param $classKeywordTo
     */
    public function __construct($namespaceKeywordFrom, $namespaceKeywordTo, $classKeywordFrom, $classKeywordTo)
    {
        $this->namespaceKeywordFrom = $namespaceKeywordFrom;
        $this->namespaceKeywordTo = $namespaceKeywordTo;
        $this->classKeywordFrom = $classKeywordFrom;
        $this->classKeywordTo = $classKeywordTo;
    }

    function resolve(\ReflectionClass $repositoryReflection) : string
    {
        $namespaceName = $repositoryReflection->getNamespaceName();
        $className = $repositoryReflection->getShortName();
        if(StringUtils::hasLength($this->namespaceKeywordFrom)){
            $entityNamespace = str_replace($this->namespaceKeywordFrom, $this->namespaceKeywordTo, $namespaceName);
        }
        if(StringUtils::hasLength($this->classKeywordFrom)){
            $entityClassName = str_replace($this->classKeywordFrom, $this->classKeywordTo, $className);
        }
        return sprintf('%s\\%s',$entityNamespace, $entityClassName);
    }

    function support(\ReflectionClass $repositoryReflection, $repositoryName) : bool
    {
        return true;
    }


}