<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:45 PM
 */

namespace DoctrineData\Metadata\Repository;


use Doctrine\Common\Annotations\Reader;
use DoctrineData\Annotation\NoRepositoryBean;
use DoctrineData\Annotation\Repository;
use DoctrineData\Options\ConfigOptions;
use DoctrineData\Repository\DoctrineDataRepository;
use DoctrineData\Resolver\EntityResolver;
use PhpCommonUtil\Util\Assert;
use PhpCommonUtil\Util\TypeUtils;
use Psr\Log\LoggerInterface;
use Zend\Code\Scanner\DerivedClassScanner;
use Zend\Code\Scanner\MethodScanner;
use Zend\Code\Scanner\ParameterScanner;

class RepositoryMetadataExtractor
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var ConfigOptions
     */
    private $configOptions;

    /**
     * @var array
     */
    private $resolvers = [];

    /**
     * RepositoryMetadataExtractor constructor.
     * @param LoggerInterface $logger
     * @param Reader $reader
     * @param ConfigOptions $configOptions
     */
    public function __construct(LoggerInterface $logger, Reader $reader, ConfigOptions $configOptions)
    {
        $this->logger = $logger;
        $this->reader = $reader;
        $this->configOptions = $configOptions;
        foreach ($configOptions->getEntityResolvers() as $resolver){
            if( !array_key_exists($resolver->getPriority(), $this->resolvers)){
                $this->resolvers[$resolver->getPriority()] = [];
            }
            $this->resolvers[$resolver->getPriority()][] = $resolver->getResolver();
        }
        krsort($this->resolvers);
    }

    public function resolveEntityName(\ReflectionClass $reflectionClass) {
        foreach ($this->resolvers as $resolversWithSamePriority){
            foreach ( $resolversWithSamePriority as $resolver ) {
                /* @var $resolver EntityResolver */
                if ($resolver->support($reflectionClass)) {
                    return $resolver->resolve($reflectionClass);
                }
            }
        }
        return null;
    }

    /**
     * @param array $classes
     * @param array $repositoryMap
     * @param array $entityMap
     * @param array $allRepositoryMap
     * @return RepositoryMetadata[]
     */
    public function extractRepositoryMetadata(array $classes, array &$repositoryMap, array &$entityMap, array &$allRepositoryMap) : array
    {
        $tmp = [];
        foreach ($classes as $clazz) {
            /* @var $clazz DerivedClassScanner */
            if (array_key_exists($clazz->getName(), $allRepositoryMap)) {
                $tmp[] = $allRepositoryMap[$clazz->getName()];
                continue;
            }

            $reader = $this->reader;

            $repositoryMetadata = new RepositoryMetadata();
            $clazzReflection = new \ReflectionClass($clazz);
            /* @var $repository  Repository */
            $repository = $reader->getClassAnnotation($clazzReflection, Repository::class);
            $entityName = null;
            if (null != $repository){
                Assert::hasLength($repository->entityName, sprintf('You provide empty entityName in RepositoryAnnotation on repository class "%s"', $clazzReflection->getName()));
                $repositoryMetadata->setEntityClassName($entityName);
            } else {
                $repositoryMetadata->setEntityClassName($this->resolveEntityName($clazzReflection));
                Assert::hasLength($repositoryMetadata->getEntityClassName(), sprintf('Unable to resolve entity class from repository class "%s"', $clazzReflection->getName()));
            }
            $type = null;
            $noRepositoryBean = $reader->getClassAnnotation($clazzReflection, NoRepositoryBean::class);
            if (TypeUtils::isAssignable($clazzReflection, DoctrineDataRepository::class) && null == $noRepositoryBean) {
                $type = RepositoryMetadata::$_TYPE_REPOSITORY;
                $repositoryMap[$repositoryMetadata->getRepositoryInterfaceName()] = $repositoryMetadata;
                $entityMap[$repositoryMetadata->getEntityClassName()] = $repositoryMetadata;
            } elseif (TypeUtils::isAssignable($clazzReflection, DoctrineDataRepository::class) && null != $noRepositoryBean) {
                $type = RepositoryMetadata::$_TYPE_NO_REPOSITORY;
            } else {
                $type = RepositoryMetadata::$_TYPE_CUSTOM;
            }

            $repositoryMetadata->setType($type);
            $repositoryMetadata->setParents($clazz->getInterfaces());
            $repositoryMetadata->setRepositoryInterfaceName($clazz->getName());
//            $repositoryMetadata->setEntityClassName()
            $repositoryMetadata->setMethods($this->extractMethodsMetadata($clazz));

            $tmp[] = $repositoryMetadata;
            $allRepositoryMap[$repositoryMetadata->getRepositoryInterfaceName()] = $repositoryMetadata;

            $repositoryMetadata->setParents($this->extractRepositoryMetadata($clazz->getInterfaces(true), $repositoryMap, $entityMap, $allRepositoryMap));
        }

        return $tmp;
    }

    /**
     * @param $class DerivedClassScanner
     * @return MethodMetadata[]
     */
    public function extractMethodsMetadata(DerivedClassScanner $class) : array
    {
        $result = [];
        foreach ($class->getMethods() as $method) {
            $metadata = new MethodMetadata();
            $metadata->setParameters($this->extractParameterMetadata($method));
            $method->getParameters(true);
            $result[] = $metadata;
        }
        return $result;

    }

    /**
     * @param $method MethodScanner
     * @return ParameterMetadata[]
     */
    public function extractParameterMetadata(MethodScanner $method) : array
    {
        $result = [];
        foreach ($method->getParameters(true) as $parameter) {
            /* @var $parameter ParameterScanner */
            $metadata = new ParameterMetadata();
            $metadata->setPosition($parameter->getPosition());
            $result[] = $metadata;
        }
        return $result;

    }

}