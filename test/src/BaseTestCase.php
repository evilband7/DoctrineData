<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/15/2016
 * Time: 12:55 AM
 */

namespace DoctrineDataTest\DoctrineData;


use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use DoctrineData\Options\ConfigOptions;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class BaseTestCase extends  TestCase
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ConfigOptions
     */
    protected $config;

    /**
     * @var Cache
     */
    protected $cache;


    public function setUp(){
        /*  ------------------------   */
        $logger = new Logger('test');
        $curDate = new \DateTime();
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../log/' . $curDate->format('y-m-d') . '.log', Logger::DEBUG));
        $this->logger = $logger;
        /*  ------------------------   */
        $this->config = new ConfigOptions([
            'proxy_location' => __DIR__ . '/../proxies',
            'interface_suffix' => 'Interface',
            'implementation_suffix' => '',
            'proxy_namespace' => 'DoctrineDataProxy\\',
            'is_debug_mode_enabled' => true,
            'directory_to_scan' => [
                __DIR__ . '/Repository',
            ],
        ]);
        /*  ------------------------   */
        $this->cache = new ArrayCache();
        $this->cache->setNamespace('TestNamespace');
        /*  ------------------------   */
    }

}