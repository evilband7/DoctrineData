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
use DoctrineData\Annotation\Repository;
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
    private $cofigOptions;

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
     * @param ConfigOptions $cofigOptions
     * @param Cache $cache
     */
    public function __construct(ConfigOptions $cofigOptions, Cache $cache, LoggerInterface $logger)
    {
        $this->cofigOptions = $cofigOptions;
        $this->cache = $cache;
        $this->logger = $logger;
    }


    public function getMedatada()
    {
        if ( null == $this->metadata ){
            $this->metadata = $this->loadMetadata();
        }
        return $this->metadata;
    }

    public function loadMetadata() : Metadata
    {
        $cacheKey   = $this->cofigOptions->getMetadataCacheKey();
        $cache      = $this->cache;

        if( $cache->contains($cacheKey)){
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
        $isDebugEnabled = $this->cofigOptions->isIsDebugModeEnabled();
        $reader = $this->getAnnotationReader();
        if(empty($dirs)){
            $dirs = $this->cofigOptions->getDirectoryToScan();
        }
        if( $isDebugEnabled ){
            $this->logger->debug('DoctrineData is Scanning the following directories for repository: {dirs}',['dirs'=>$dirs]);
        }
        $result = [];
        foreach ($dirs as $dir){
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
                        $clazz = new \ReflectionClass($className);
                        if( $clazz->isInterface() && TypeUtils::isAssignable($clazz, DoctrineDataRepositoryInterface::class) ){
                            /* @var $repository Repository */
                            $repository = $reader->getClassAnnotation($clazz, Repository::class);
                            if ( null != $this->$repository && StringUtils::hasLength($repository->getEntityName()) ){
                                $result[] = $clazz;
                            }
                        }
                    }
                }else if( is_dir($file) ){
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