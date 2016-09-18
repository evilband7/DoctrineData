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
use Zend\Code\Scanner\DerivedClassScanner;
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
     * @param LoggerInterface $logger
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

        $reader = $this->getAnnotationReader();
        $classes = $this->findPhpClassesInTargetDirs();
        $extractor = new RepositoryMetadataExtractor($this->logger, $reader, $this->configOptions);
        $repositoryMap = [];
        $entityMap = [];
        $allRepositoryMap = [];
        $extractor->extractRepositoryMetadata($classes, $repositoryMap, $entityMap, $allRepositoryMap);

        $metadata = new Metadata();
        $metadata->setEntityMap($entityMap);
        $metadata->setRepositoryMap($repositoryMap);
        return $metadata;
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

        foreach ($scanner->getClasses() as $class ) {
            /* @var $class DerivedClassScanner  */
            $classReflection = new \ReflectionClass($class->getName());
            if( $class->isInterface() && TypeUtils::isAssignable($classReflection, DoctrineDataRepositoryInterface::class) ){
                $noRepositoryBean = $reader->getClassAnnotation($classReflection, NoRepositoryBean::class);
                if ( null == $noRepositoryBean ){
                    $result[] = $class;
                    if( $isDebugEnabled ){
                        $this->logger->debug('Found Repository "{class}" ', ['class'=>$class->getName()]);
                    }
                    continue;
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