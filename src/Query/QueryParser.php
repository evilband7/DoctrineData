<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/17/2016
 * Time: 7:38 PM
 */

namespace DoctrineData\Query;


use DoctrineData\Options\ConfigOptions;
use Psr\Log\LoggerInterface;

class QueryParser
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ConfigOptions
     */
    private $configOptions;

    /**
     * QueryParser constructor.
     * @param LoggerInterface $logger
     * @param ConfigOptions $configOptions
     */
    public function __construct(LoggerInterface $logger, ConfigOptions $configOptions)
    {
        $this->logger = $logger;
        $this->configOptions = $configOptions;
    }


    public function parse(string $query, array $context) : string
    {
        $isDebugMode = $this->configOptions->isIsDebugModeEnabled();
        if($isDebugMode){
            $this->logger->debug(sprintf('parsing Query "%s" with context "%s"', $query, json_encode($context)));
        }
        $start = strpos($query, '#{');
        if ( false === $start ){
            return $query;
        }else{
            $end = strpos($query, '}', $start);
            if ( false == $end ){
                return $query;
            }else{
                $end=$end+1;
                $target = substr($query, $start+2, ($end-1)-($start+2));
                $replacing = $context[$target];
                $result = substr_replace($query, $replacing, $start, $end-$start);
                if( $isDebugMode ){
                    $this->logger->debug(sprintf('Replacing "#{%s}" with "%s"', $target, $replacing));
                }
                return $this->parse($result, $context);
            }
        }
    }


}