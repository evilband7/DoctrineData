<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/15/2016
 * Time: 1:54 AM
 */

namespace DoctrineDataTest\DoctrineData\Assets\Repository;
use DoctrineData\Annotation\Repository;

/**
 * @Repository(entityName="Test")
 */
interface TestRepository extends  TestNoRepository , TestRepositoryCustom
{

    function repository();
}