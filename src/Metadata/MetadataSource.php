<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:10 PM
 */

namespace DoctrineData\Metadata;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\Cache;
use DoctrineData\Annotation\NoRepositoryBean;
use DoctrineData\Metadata\Repository\RepositoryMetadataExtractor;
use DoctrineData\Options\ConfigOptions;
use DoctrineData\Repository\DoctrineDataRepositoryInterface;
use PhpCommonUtil\Util\Assert;
use PhpCommonUtil\Util\StringUtils;
use PhpCommonUtil\Util\TypeUtils;
use Psr\Log\LoggerInterface;
use Zend\Code\Scanner\FileScanner;
use Zend\Stdlib\ArrayUtils;

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

    public function findPhpClassesInTargetDirs(array $dirs = []) : array
    {
        $isDebugEnabled = $this->configOptions->isIsDebugModeEnabled();
        $reader = $this->getAnnotationReader();
        if(empty($dirs)){
            $dirs = $this->configOptions->getDirectoryToScan();
        }
        if( $isDebugEnabled ){
            $this->logger->debug('DoctrineData is Scanning the following directories for noRepository: {dirs}',['dirs'=>$dirs]);
        }
        $result = [];
        foreach ($dirs as $dir){
            $this->logger->debug('Scanning directory "{dir}"', ['dir'=>$dir]);
            Assert::isTrue(is_string($dir), sprintf('Invalid directory "%s" ', $dir));
            Assert::isTrue(file_exists($dir), sprintf('Invalid directory "%s" ', $dir));
            Assert::isTrue(is_dir($dir), sprintf('Invalid directory "%s" ', $dir));
            $files = scandir($dir);

            foreach ($files as $file){
                if ( StringUtils::endsWith($file, '.php')){
                    $file = $dir . '/' . $file;
                    $scanner = new FileScanner($file);
                    ArrayUtils::merge($result, $scanner->getClassNames());
                    foreach( $scanner->getClassNames() as $className ){
                        $this->logger->debug('Found class: ',['class'=>$className]);
                        $clazz = new \ReflectionClass($className);
                        if( $clazz->isInterface() && TypeUtils::isAssignable($clazz, DoctrineDataRepositoryInterface::class) ){
                            $noRepositoryBean = $reader->getClassAnnotation($clazz, NoRepositoryBean::class);
                            $this->logger->debug('Found Repository "{class}" ', ['class'=>$className]);
                            if ( null == $noRepositoryBean ){
                                $result[] = $clazz;
                                conitnue;
                            }
                        }
                    }
                }else if( '.' != $file && '..' != $file && is_dir($file) ){
                    ArrayUtils::merge($result, $this->findPhpClassesInTargetDirs([$file]));
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