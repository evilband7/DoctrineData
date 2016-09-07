<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/06/2016
 * Time: 3:30 AM
 */

namespace DoctrineData\Repository\Support;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

trait ConstructorSupport
{

    /**
     * @var EntityManager
     */
    private $_em;

    /**
     * @var string
     */
    private $_entityName;

    /**
     * @var ClassMetadata
     */
    private $_class;

    /**
     * Initializes a new <tt>EntityRepository</tt>.
     *
     * @param EntityManager $em    The EntityManager to use.
     * @param ClassMetadata $class The class descriptor.
     */
    public function __construct($em, ClassMetadata $class)
    {
        $this->_entityName = $class->name;
        $this->_em         = $em;
        $this->_class      = $class;
    }

}