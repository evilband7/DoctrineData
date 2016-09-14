<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/15/2016
 * Time: 12:55 AM
 */

namespace DoctrineDataTest\DoctrineData;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

abstract class BaseTestCase extends  TestCase
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function setUp(){
        $logger = new Logger('test');
        $curDate = new \DateTime();
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../log/' . $curDate->format('y-m-d') . '.log', Logger::DEBUG));
        $this->logger = $logger;
    }

}