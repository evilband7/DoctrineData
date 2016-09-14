<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:10 PM
 */

namespace DoctrineData\Metadata;


use Doctrine\Common\Cache\Cache;
use DoctrineData\Metadata\Repository\RepositoryMetadataExtractor;
use DoctrineData\Options\ConfigOptions;
use PhpCommonUtil\Util\Assert;
use Psr\Log\LoggerInterface;
use Zend\Code\Scanner\FileScanner;

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

        $dirs = $this->cofigOptions->getDirectoryToScan();
        $extractor = new RepositoryMetadataExtractor($this->logger);
        foreach ($dirs as $dir){
            Assert::isTrue(is_string($dir), sprintf('Invalid directory "%s" ', $dir));
            Assert::isTrue(file_exists($dir), sprintf('Invalid directory "%s" ', $dir));
            Assert::isTrue(is_dir($dir), sprintf('Invalid directory "%s" ', $dir));
            $files = scandir($dir);
            foreach ($files as $file){
                if ($this->endswith('.php', $file)){
                    $file = $dir . '/' . $file;
                    $scanner = new FileScanner($file);
                    foreach ( $scanner->getClassNames() as $className){
                        $clazz = new \ReflectionClass($className);
                        $extractor->extract($clazz);
                    }

                }
            }
        }
    }

    private function endswith($string, $test) {
        $strlen = strlen($string);
        $testlen = strlen($test);
        if ($testlen > $strlen) return false;
        return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
    }

}