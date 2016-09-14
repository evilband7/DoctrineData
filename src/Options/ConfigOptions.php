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
    private $metadataCacheKey;

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





}