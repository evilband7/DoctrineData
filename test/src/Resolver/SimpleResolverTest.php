<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/18/2016
 * Time: 1:24 AM
 */

namespace DoctrineDataTest\DoctrineData\Resolver;


use DoctrineData\Resolver\SimpleEntityResolver;
use DoctrineDataTest\DoctrineData\Assets\Repository\TestRepository;
use DoctrineDataTest\DoctrineData\BaseTestCase;

class SimpleResolverTest extends  BaseTestCase
{
    public function test(){
        $resolver = new SimpleEntityResolver('Repository','Entity','Repository','Entity');
        $repositoryReflection = new \ReflectionClass(TestRepository::class);
        $repositoryName = TestRepository::class;
        $entityName = $resolver->resolve($repositoryReflection, $repositoryName);
        $expectedEntityName = 'DoctrineDataTest\DoctrineData\Assets\Entity\TestEntity';
        $this->assertTrue($resolver->support($repositoryReflection, $repositoryName));
        $this->assertEquals($expectedEntityName, $entityName);

        $resolver = new SimpleEntityResolver('Repository','Entity','Repository','');
        $entityName = $resolver->resolve($repositoryReflection, $repositoryName);
        $expectedEntityName = 'DoctrineDataTest\DoctrineData\Assets\Entity\Test';
        $this->assertTrue($resolver->support($repositoryReflection, $repositoryName));
        $this->assertEquals($expectedEntityName, $entityName);

    }


}