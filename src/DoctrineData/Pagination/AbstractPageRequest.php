<?php
namespace DoctrineData\Pagination;

abstract class AbstractPageRequest implements  PageableInterface
{

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $size;
    
    /**
     * Creates a new {@link AbstractPageRequest}. Pages are zero indexed, thus providing 0 for {@code page} will return
     * the first page.
     *
     * @param int $page must not be less than zero.
     * @param int $size must not be less than one.
     */
    public function __construct(int $page, int $size) {
    
        if ($page < 0) {
            throw new \InvalidArgumentException('Page index must not be less than zero!');
        }
    
        if ($size < 1) {
            throw new \InvalidArgumentException('Page size must not be less than one!');
        }
    
        $this->page = $page;
        $this->size = $size;
    }
    
    public function getPageSize() : int {
        return $this->size;
    }
    
    public function  getPageNumber() : int {
        return $this->page;
    }
    
    public function getOffset() : int {
        return $this->page * $this->size;
    }
    
    public function  hasPrevious() : bool {
        return $this->page > 0;
    }
    
    public function  previousOrFirst() : PageableInterface {
        return $this->hasPrevious() ? $this->previous() : $this->first();
    }
    
    public abstract function next() : PageableInterface;
    
    /**
     * @return PageableInterface
    */
    public abstract function previous() : PageableInterface;
    
    /**
     * @return PageableInterface
     */
    public abstract function first() : PageableInterface;
    
}