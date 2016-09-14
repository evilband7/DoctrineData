<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/15/2016
 * Time: 12:51 AM
 */

namespace DoctrineDataTest\DoctrineData\Scanner;


use DoctrineDataTest\DoctrineData\BaseTestCase;
use Zend\Code\Scanner\FileScanner;

class ClassScannerTest extends  BaseTestCase
{
    public function test(){
        $file  = new FileScanner(__DIR__ . '/../../assets/php/MultipleClassesFile.php');
        foreach( $file->getClassNames() as $className ){
            $this->logger->debug(sprintf('Found class: %s', $className));
        }
    }

}