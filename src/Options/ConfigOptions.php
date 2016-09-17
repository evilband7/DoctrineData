<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:46 PM
 */

namespace DoctrineData\Options;


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

    private $interfaceSuffix = 'Interface';

    private $implementationSuffix = 'Impl' ;

    private $proxyNamespace = 'DoctrineDataProxy\\';

    private $proxyLocation = null;

    private $isDebugModeEnabled = false;

    /**
     * @return mixed
     */
    public function getDirectoryToScan() : array
    {
        return $this->directoryToScan;
    }

    /**
     * @param mixed $directoryToScan
     */
    public function setDirectoryToScan(array $directoryToScan)
    {
        $this->directoryToScan = $directoryToScan;
    }

    /**
     * @return mixed
     */
    public function getMetadataCacheKey() : string
    {
        return $this->metadataCacheKey;
    }

    /**
     * @param mixed $metadataCacheKey
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
     * @return null
     */
    public function getProxyLocation()
    {
        return $this->proxyLocation;
    }

    /**
     * @param null $proxyLocation
     */
    public function setProxyLocation($proxyLocation)
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



}