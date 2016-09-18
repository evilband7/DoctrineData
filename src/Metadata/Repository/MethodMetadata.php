<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/19/2016
 * Time: 5:22 AM
 */

namespace DoctrineData\Metadata\Repository;


class MethodMetadata
{

    /**
     * @var string
     */
    private $query;

    /**
     * @var bool
     */
    private $isNative = false;

    /**
     * @var ParameterMetadata[]
     */
    private $parameters;

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query)
    {
        $this->query = $query;
    }

    /**
     * @return boolean
     */
    public function isIsNative(): bool
    {
        return $this->isNative;
    }

    /**
     * @param boolean $isNative
     */
    public function setIsNative(bool $isNative)
    {
        $this->isNative = $isNative;
    }

    /**
     * @return ParameterMetadata[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param ParameterMetadata[] $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }



}