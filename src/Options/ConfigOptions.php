<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:46 PM
 */

namespace DoctrineData\Options;


use DoctrineData\Resolver\EntityResolver;
use Zend\Stdlib\AbstractOptions;

class ConfigOptions extends  AbstractOptions
{

    /**
     * @var array
     */
    private $directoryToScan;

    /**
     * @var string
     */
    private $metadataCacheKey = 'DoctrineDataConfigCache';

    /**
     * @var string
     */
    private $interfaceSuffix = 'Interface';

    /**
     * @var string
     */
    private $implementationSuffix = 'Impl' ;

    /**
     * @var string
     */
    private $proxyNamespace = 'DoctrineDataProxy\\';

    /**
     * @var string
     */
    private $proxyLocation = null;

    /**
     * @var bool
     */
    private $isDebugModeEnabled = false;

    /**
     * @var ResolverOptions[]
     */
    private $entityResolvers = [];

    /**
     * @return array
     */
    public function getDirectoryToScan(): array
    {
        return $this->directoryToScan;
    }

    /**
     * @param array $directoryToScan
     */
    public function setDirectoryToScan(array $directoryToScan)
    {
        $this->directoryToScan = $directoryToScan;
    }

    /**
     * @return string
     */
    public function getMetadataCacheKey(): string
    {
        return $this->metadataCacheKey;
    }

    /**
     * @param string $metadataCacheKey
     */
    public function setMetadataCacheKey(string $metadataCacheKey)
    {
        $this->metadataCacheKey = $metadataCacheKey;
    }

    /**
     * @return string
     */
    public function getInterfaceSuffix(): string
    {
        return $this->interfaceSuffix;
    }

    /**
     * @param string $interfaceSuffix
     */
    public function setInterfaceSuffix(string $interfaceSuffix)
    {
        $this->interfaceSuffix = $interfaceSuffix;
    }

    /**
     * @return string
     */
    public function getImplementationSuffix(): string
    {
        return $this->implementationSuffix;
    }

    /**
     * @param string $implementationSuffix
     */
    public function setImplementationSuffix(string $implementationSuffix)
    {
        $this->implementationSuffix = $implementationSuffix;
    }

    /**
     * @return string
     */
    public function getProxyNamespace(): string
    {
        return $this->proxyNamespace;
    }

    /**
     * @param string $proxyNamespace
     */
    public function setProxyNamespace(string $proxyNamespace)
    {
        $this->proxyNamespace = $proxyNamespace;
    }

    /**
     * @return string
     */
    public function getProxyLocation(): string
    {
        return $this->proxyLocation;
    }

    /**
     * @param string $proxyLocation
     */
    public function setProxyLocation(string $proxyLocation)
    {
        $this->proxyLocation = $proxyLocation;
    }

    /**
     * @return boolean
     */
    public function isIsDebugModeEnabled(): bool
    {
        return $this->isDebugModeEnabled;
    }

    /**
     * @param boolean $isDebugModeEnabled
     */
    public function setIsDebugModeEnabled(bool $isDebugModeEnabled)
    {
        $this->isDebugModeEnabled = $isDebugModeEnabled;
    }

    /**
     * @return ResolverOptions[]
     */
    public function getEntityResolvers(): array
    {
        return $this->entityResolvers;
    }

    /**
     * @param ResolverOptions[]|array $entityResolvers
     */
    public function setEntityResolvers(array $entityResolvers)
    {
        $finalResolvers = [];
        foreach ($entityResolvers as $resolver) {
            if ( $resolver instanceof ResolverOptions ) {
                $finalResolvers[] = $resolver;
            }else{
                $finalResolvers[] = new ResolverOptions($resolver);
            }
        }
        $this->entityResolvers = $finalResolvers;
    }



}