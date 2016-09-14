<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:45 PM
 */

namespace DoctrineData\Metadata\Repository;


class RepositoryMetadata
{

    public static $_TYPE_REPOSITORY = 1;
    public static $_TYPE_NO_REPOSITORY = 2;
    public static $_TYPE_CUSTOM = 3;

    /**
     * @var string
     */
    private $entityClassName;

    /**
     * @var string
     */
    private $repositoryInterfaceName;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var array
     */
    private $parents;

    /**
     * @return string
     */
    public function getEntityClassName(): string
    {
        return $this->entityClassName;
    }

    /**
     * @param string $entityClassName
     */
    public function setEntityClassName(string $entityClassName)
    {
        $this->entityClassName = $entityClassName;
    }

    /**
     * @return string
     */
    public function getRepositoryInterfaceName(): string
    {
        return $this->repositoryInterfaceName;
    }

    /**
     * @param string $repositoryInterfaceName
     */
    public function setRepositoryInterfaceName(string $repositoryInterfaceName)
    {
        $this->repositoryInterfaceName = $repositoryInterfaceName;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getParents(): array
    {
        return $this->parents;
    }

    /**
     * @param array $parents
     */
    public function setParents(array $parents)
    {
        $this->parents = $parents;
    }

}