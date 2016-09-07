<?php
namespace  DoctrineData\Pagination\Sorting;
use MyCLabs\Enum\Enum;

/**
 * Class NullHandling
 * @package DoctrineData\Pagination\Sorting
 * @method NullHandling NATIVE()
 */
class NullHandling extends Enum
{
    const NATIVE = 'NATIVE';

    const NULLS_FIRST = 'NULLS_FIRST';
    
    const NULLS_LAST = 'NULLS_LAST';
    
}