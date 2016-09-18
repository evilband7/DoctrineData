<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/19/2016
 * Time: 5:23 AM
 */

namespace DoctrineData\Metadata\Repository;


class ParameterMetadata
{
    public static $TYPE_NATIVE = 1;
    public static $TYPE_PAGINATION = 2;
    public static $TYPE_OBJECT = 3;

    /**
     * @var int
     */
    private $type;

    /**
     * @var int
     */
    private $position;

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
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position)
    {
        $this->position = $position;
    }





}