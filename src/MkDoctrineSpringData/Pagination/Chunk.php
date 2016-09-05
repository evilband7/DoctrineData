<?php

namespace MkDoctrineSpringData\Pagination;

use PhpCommonUtil\Util\Assert;
use JMS\Serializer\Annotation as Serializer;

abstract  class Chunk implements  SliceInterface
{
    
    /**
     * 
     * @var array
     */
    private $content = array();
    
    /**
     * @var PageableInterface
     */
    private $pageable;
    
    /**
     * Creates a new {@link Chunk} with the given content and the given governing {@link Pageable}.
     *
     * @param array content must not be {@literal null}.
     * @param PageableInterface pageable can be {@literal null}.
     */
    public function  __construct(array $content, PageableInterface $pageable) {
        Assert::notNull($content, "Content must not be null!");
        $this->content = array_merge($this->content, $content);
        $this->pageable = $pageable;
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::getNumber()
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("number")
     */
    public function  getNumber() {
        return $this->pageable == null ? 0 : $this->pageable->getPageNumber();
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::getSize()
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("size")
     */
    public function getSize() {
        return $this->pageable == null ? 0 : $this->pageable->getPageSize();
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::getNumberOfElements()
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("numberOfElements")
     */
    public function  getNumberOfElements() {
        return count($this->content);
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::hasPrevious()
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("hasPrevious")
     */
    public function hasPrevious() {
        return $this->getNumber() > 0;
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::isFirst()
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("isFirst")
     */
    public function isFirst() {
        return ! $this->hasPrevious();
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::isLast()
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("isLast")
     */
    public function isLast() {
        return ! $this->hasNext();
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::nextPageable()
     */
    public function nextPageable() {
        return  $this->hasNext() ? $this->pageable->next() : null;
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::previousPageable()
     */
    public function previousPageable() {
        if( $this->hasPrevious()){
            return $this->pageable->previousOrFirst();
        }
        return null;
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::hasContent()
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("hasContent")
     */
    public function hasContent() {
        return !empty($this->content);
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::getContent()
     */
    public function getContent() {
        $arrayObject = new \ArrayObject($this->content);
        return $arrayObject->getArrayCopy();
    }
    
    /**
     * @see \MkDoctrineSpringData\Pagination\SliceInterface::getSort()
     */
    public function getSort() {
        return $this->pageable == null ? null : $this->pageable->getSort();
    }
    
    /**
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator() {
        return new \ArrayObject($this->content);
    }
    
}