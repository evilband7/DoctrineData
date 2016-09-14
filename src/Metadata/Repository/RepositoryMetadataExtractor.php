<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:45 PM
 */

namespace DoctrineData\Metadata\Repository;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Psr\Log\LoggerInterface;

class RepositoryMetadataExtractor
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * RepositoryMetadataExtractor constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->reader = new AnnotationReader();
    }


    public function extract(\ReflectionClass $class){


    }

}