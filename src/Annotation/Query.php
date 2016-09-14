<?php
namespace DoctrineData\Annotation;

/**
 * @Annotation
 *
 */
class Query
{
    private $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }



}

?>