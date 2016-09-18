<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/15/2016
 * Time: 1:54 AM
 */

namespace DoctrineDataTest\DoctrineData\Assets\Repository;

use DoctrineData\Annotation\NoRepositoryBean;
use DoctrineData\Repository\DoctrineDataRepositoryInterface;

/**
 * @NoRepositoryBean()
 */
interface TestNoRepository extends DoctrineDataRepositoryInterface  , TestNoRepositoryCustom
{

    function noRepository();

}