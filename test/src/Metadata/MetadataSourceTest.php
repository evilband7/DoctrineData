<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/18/2016
 * Time: 1:38 AM
 */

namespace DoctrineDataTest\DoctrineData\Metadata;


use DoctrineData\Metadata\MetadataSource;
use DoctrineData\Repository\DoctrineDataRepositoryInterface;
use DoctrineDataTest\DoctrineData\Assets\Repository\TestRepository;
use DoctrineDataTest\DoctrineData\BaseTestCase;
use PhpCommonUtil\Util\TypeUtils;

class MetadataSourceTest extends  BaseTestCase
{

    public function test(){
        $this->assertTrue(TypeUtils::isAssignable(TestRepository::class, DoctrineDataRepositoryInterface::class));
        $this->assertNotEmpty($this->config->getDirectoryToScan());
        $metadataSource = new MetadataSource($this->config, $this->cache, $this->logger);
        $classes = $metadataSource->findPhpClassesInTargetDirs();
        foreach ($classes as $clazz){
            $this->logger->debug('class: {class}', ['class'=>$clazz->getName()]);
        }
    }

}