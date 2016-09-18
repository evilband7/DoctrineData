<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/14/2016
 * Time: 11:11 PM
 */

namespace DoctrineData\Metadata;


use DoctrineData\Metadata\Repository\RepositoryMetadata;

class Metadata
{
    /**
     * @var RepositoryMetadata[]
     */
    private $entityMap = [];

    /**
     * @var RepositoryMetadata[]
     */
    private $repositoryMap = [];

    /**
     * @return Repository\RepositoryMetadata[]
     */
    public function getEntityMap(): array
    {
        return $this->entityMap;
    }

    /**
     * @param Repository\RepositoryMetadata[] $entityMap
     */
    public function setEntityMap(array $entityMap)
    {
        $this->entityMap = $entityMap;
    }

    /**
     * @return Repository\RepositoryMetadata[]
     */
    public function getRepositoryMap(): array
    {
        return $this->repositoryMap;
    }

    /**
     * @param Repository\RepositoryMetadata[] $repositoryMap
     */
    public function setRepositoryMap(array $repositoryMap)
    {
        $this->repositoryMap = $repositoryMap;
    }
}