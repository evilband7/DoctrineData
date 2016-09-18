<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:10 PM
 */

namespace DoctrineData\Metadata;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\Cache;
use DoctrineData\Annotation\NoRepositoryBean;
use DoctrineData\Metadata\Repository\RepositoryMetadataExtractor;
use DoctrineData\Options\ConfigOptions;
use DoctrineData\Repository\DoctrineDataRepositoryInterface;
use PhpCommonUtil\Util\TypeUtils;
use Psr\Log\LoggerInterface;
use Zend\Code\Scanner\DirectoryScanner;

class MetadataSource
{
    /**
     * @var Metadata
     */
    private $metadata = null;

    /**
     * @var ConfigOptions
     */
    private $configOptions;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * MetadataSource constructor.
     * @param ConfigOptions $configOptions
     * @param Cache $cache
     */
    public function __construct(ConfigOptions $configOptions, Cache $cache, LoggerInterface $logger)
    {
        $this->configOptions = $configOptions;
        $this->cache = $cache;
        $this->logger = $logger;
    }


    public function getMetadata()
    {
        if ( null == $this->metadata ){
            $this->metadata = $this->loadMetadata();
        }
        return $this->metadata;
    }

    public function loadMetadata() : Metadata
    {
        $cacheKey   = $this->configOptions->getMetadataCacheKey();
        $cache      = $this->cache;

        if ( $cache->contains($cacheKey)) {
            $metadata = $cache->fetch($cacheKey);
            if ( $metadata instanceof  Metadata ){
                return $metadata;
            }else{
                $this->logger->error('Metadata from cache is conflict, try reloading..');
            }
        }

        $metadata = new Metadata();
        $extractor = new RepositoryMetadataExtractor($this->logger);
    }

    public function findPhpClassesInTargetDirs() : array
    {
        $isDebugEnabled = $this->configOptions->isIsDebugModeEnabled();
        $reader = $this->getAnnotationReader();
        $dirs = $this->configOptions->getDirectoryToScan();

        if( $isDebugEnabled ){
            $this->logger->debug('DoctrineData is Scanning the following directories for noRepository: {dirs}',['dirs'=>$dirs]);
        }

        $result = [];
        $scanner = new DirectoryScanner($dirs);
        $this->logger->debug('Found classes: ',['classes'=>$scanner->getClasses()]);

        foreach ($scanner->getClassNames() as $className ) {
            $clazz = new \ReflectionClass($className);
            $this->logger->debug('Is Assignable" ', ['Assignable'=>$clazz->isSubclassOf(DoctrineDataRepositoryInterface::class)]);
            if( $clazz->isInterface() && TypeUtils::isAssignable($clazz, DoctrineDataRepositoryInterface::class) ){
                $noRepositoryBean = $reader->getClassAnnotation($clazz, NoRepositoryBean::class);
                if ( null == $noRepositoryBean ){
                    $result[] = $clazz;
                    $this->logger->debug('Found Repository "{class}" ', ['class'=>$clazz->getName()]);
                    conitnue;
                }
            }
        }
        return $result;
    }

    /**
     * @var AnnotationReader
     */
    private $_annotationReader = null;

    private function getAnnotationReader(){
        if (null == $this->_annotationReader ){
            $this->_annotationReader = new AnnotationReader();
        }
        return $this->_annotationReader;
    }

}