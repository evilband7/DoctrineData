<?php
namespace DoctrineData\Pagination;

interface PageInterface extends SliceInterface
{
    function getTotalPages() : int ;
    function getTotalElements() : int ;
}