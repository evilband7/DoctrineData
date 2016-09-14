<?php
namespace DoctrineData\Pagination;

interface SliceInterface extends \IteratorAggregate
{
    
    /**
	 * Returns the number of the current {@link Slice}. Is always non-negative.
	 * 
	 * @return integer the number of the current {@link Slice}.
	 */
	function  getNumber() : int ;

	/**
	 * Returns the size of the {@link Slice}.
	 * 
	 * @return integer the size of the {@link Slice}.
	 */
	function getSize() : int ;

	/**
	 * Returns the number of elements currently on this {@link Slice}.
	 * 
	 * @return integer the number of elements currently on this {@link Slice}.
	 */
	function getNumberOfElements() : int;

	/**
	 * Returns the page content as {@link List}.
	 * 
	 * @return array
	 */
	function getContent() : array;

	/**
	 * Returns whether the {@link Slice} has content at all.
	 * 
	 * @return boolean
	 */
	function  hasContent() : bool;

	/**
	 * Returns the sorting parameters for the {@link Slice}.
	 * 
	 * @return Sort
	 */
	function  getSort() : Sort;

	/**
	 * Returns whether the current {@link Slice} is the first one.
	 * 
	 * @return boolean
	 */
	function isFirst() : bool ;

	/**
	 * Returns whether the current {@link Slice} is the last one.
	 * 
	 * @return boolean
	 */
	function isLast() : bool;

	/**
	 * Returns if there is a next {@link Slice}.
	 * 
	 * @return boolean if there is a next {@link Slice}.
	 */
	function hasNext() : bool ;

	/**
	 * Returns if there is a previous {@link Slice}.
	 * 
	 * @return boolean if there is a previous {@link Slice}.
	 */
	function hasPrevious() : bool ;

	/**
	 * Returns the {@link Pageable} to request the next {@link Slice}. Can be {@literal null} in case the current
	 * {@link Slice} is already the last one. Clients should check {@link #hasNext()} before calling this method to make
	 * sure they receive a non-{@literal null} value.
	 * 
	 * @return PageableInterface
	 */
	function nextPageable() : PageableInterface;

	/**
	 * Returns the {@link Pageable} to request the previous {@link Slice}. Can be {@literal null} in case the current
	 * {@link Slice} is already the first one. Clients should check {@link #hasPrevious()} before calling this method make
	 * sure receive a non-{@literal null} value.
	 * 
	 * @return PageableInterface
	 */
	function  previousPageable() : PageableInterface;
    
    
}