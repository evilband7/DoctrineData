<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/18/2016
 * Time: 12:11 AM
 */

namespace DoctrineDataTest\DoctrineData\Query;


use DoctrineData\Query\QueryParser;
use DoctrineDataTest\DoctrineData\BaseTestCase;

class QueryParserTest extends  BaseTestCase
{

    public function testParser(){

        /* ---------------------------- */
        $parser = new QueryParser($this->logger, $this->config);
        $context = ['entityName'=>'SampleProduct'];

        $query = 'select e from #{entityName} e';
        $expectedResult = 'select e from SampleProduct e';
        $result = $parser->parse($query, $context);
        $this->assertEquals($expectedResult, $result);

        /* ---------------------------- */

        $query = 'select e1, e2 from #{entityName} e1, #{entityName} e2';
        $expectedResult = 'select e1, e2 from SampleProduct e1, SampleProduct e2';
        $result = $parser->parse($query, $context);
        $this->assertEquals($expectedResult, $result);

        /* ---------------------------  */
    }
}