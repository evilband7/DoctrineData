<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/18/2016
 * Time: 12:50 AM
 */

namespace DoctrineData\Resolver;


use DoctrineData\Exception\EntityResolvingException;
use DoctrineData\Options\ConfigOptions;
use PhpCommonUtil\Util\Assert;
use PhpCommonUtil\Util\StringUtils;
use Psr\Log\LoggerInterface;
use Zend\Stdlib\ArrayUtils;

class EntityResolverChain
{
    /**
     * @var array
     */
    private $resolvers;

    /**
     * @var EntityResolver
     */
    private $defaultResolver;

    /**
     * @var ConfigOptions
     */
    private $configOptions;

    /**
     * @var LoggerInterface
     */
    private $loggerInterface;

    /**
     * EntityResolverChain constructor.
     * @param array $resolvers
     * @param ConfigOptions $configOptions
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(array $resolvers, ConfigOptions $configOptions, LoggerInterface $loggerInterface)
    {
        $this->resolvers = $resolvers;
        $this->configOptions = $configOptions;
        $this->loggerInterface = $loggerInterface;
    }


    function resolve($repositoryName) : string
    {
        ksort($this->resolvers);
        $repository = new \ReflectionClass($repositoryName);
        foreach ($this->resolvers as $resolvers ){
            foreach ($resolvers as $resolver){
                /* @var $resolver EntityResolver */
                Assert::isInstanceOf(EntityResolver::class, $resolver);
                if( $resolver->support($repository, $repositoryName) ){
                    return $resolver->resolve($repositoryName);
                }
            }
        }
        throw new EntityResolvingException(sprintf('Unable to resolve repositoryName "%s"', $repositoryName));
    }

}