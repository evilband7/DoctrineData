<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/18/2016
 * Time: 5:45 PM
 */

namespace DoctrineDataTest\DoctrineData\Metadata;


use DoctrineDataTest\DoctrineData\BaseTestCase;
use Zend\Code\Scanner\FileScanner;
use Zend\Debug\Debug;

class MetadataExtractorTest extends  BaseTestCase
{
    public function test(){
        $fileScanner = new FileScanner(__DIR__ . '/../Assets/Repository/TestRepository.php');
        $clazz = $fileScanner->getClasses()[0];
//        $clazzReflection = new \ReflectionClass($clazz->getName());
        $interfaces = $clazz->getInterfaces();
//        $methods = $clazzReflection->getMethods();
        $this->logger->debug(Debug::dump($interfaces, null, false));
//        $this->logger->debug(Debug::dump($methods, null, false));
        foreach ($interfaces as $itf){
            $this->logger->debug('Parent Interfaces: ', ['interfaces'=>$itf]);
        }
        $this->assertEquals(2, count($interfaces));
    }


}