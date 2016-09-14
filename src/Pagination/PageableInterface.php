<?php
namespace DoctrineData\Pagination;


interface PageableInterface
{

    function getPageNumber() : int ;
    
    /**
     * Returns the number of items to be returned.
     *
     * @return int the number of items of that page
    */
    function getPageSize() : int;
    
    /**
     * Returns the offset to be taken according to the underlying page and page size.
     *
     * @return int the offset to be taken
    */
    function getOffset() : int;
    
    /**
     * Returns the sorting parameters.
     *
     * @return Sort
    */
    function getSort() : Sort;
    
    /**
     * Returns the {@link Pageable} requesting the next {@link Page}.
     *
     * @return PageableInterface
    */
    function next() : PageableInterface;
    
    /**
     * Returns the previous {@link Pageable} or the first {@link Pageable} if the current one already is the first one.
     *
     * @return PageableInterface
    */
    function previousOrFirst() : PageableInterface;
    
    /**
     * Returns the {@link Pageable} requesting the first page.
     *
     * @return PageableInterface
    */
    function  first() : PageableInterface;
    
    /**
     * Returns whether there's a previous {@link Pageable} we can access from the current one. Will return
     * {@literal false} in case the current {@link Pageable} already refers to the first page.
     *
     * @return bool
    */
    function hasPrevious() : bool;
}