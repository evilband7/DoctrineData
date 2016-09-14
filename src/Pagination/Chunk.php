<?php

namespace DoctrineData\Pagination;

use PhpCommonUtil\Util\Assert;
use JMS\Serializer\Annotation as Serializer;

abstract  class Chunk implements  SliceInterface
{
    
    /**
     * 
     * @var array
     */
    protected $content = array();
    
    /**
     * @var PageableInterface
     */
    protected $pageable;
    
    /**
     * Creates a new {@link Chunk} with the given content and the given governing {@link Pageable}.
     *
     * @param array $content must not be {@literal null}.
     * @param PageableInterface $pageable can be {@literal null}.
     */
    public function  __construct(array $content, PageableInterface $pageable) {
        Assert::notNull($content, "Content must not be null!");
        $this->content = array_merge($this->content, $content);
        $this->pageable = $pageable;
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("number")
     */
    public function  getNumber() : int {
        return $this->pageable == null ? 0 : $this->pageable->getPageNumber();
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("size")
     */
    public function getSize() : int{
        return $this->pageable == null ? 0 : $this->pageable->getPageSize();
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("numberOfElements")
     */
    public function  getNumberOfElements() : int{
        return count($this->content);
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("hasPrevious")
     */
    public function hasPrevious() : bool {
        return $this->getNumber() > 0;
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("isFirst")
     */
    public function isFirst() : bool{
        return ! $this->hasPrevious();
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("isLast")
     */
    public function isLast() : bool{
        return ! $this->hasNext();
    }

    public function nextPageable() : PageableInterface{
        return  $this->hasNext() ? $this->pageable->next() : null;
    }
    
    public function previousPageable() : PageableInterface{
        if( $this->hasPrevious()){
            return $this->pageable->previousOrFirst();
        }
        return null;
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("hasContent")
     */
    public function hasContent() : bool {
        return !empty($this->content);
    }
    
    public function getContent() : array {
        $arrayObject = new \ArrayObject($this->content);
        return $arrayObject->getArrayCopy();
    }
    
    public function getSort() : Sort{
        return $this->pageable == null ? null : $this->pageable->getSort();
    }
    
    public function getIterator() {
        return new \ArrayObject($this->content);
    }
    
}