<?php

namespace DoctrineData\Pagination;

class PageRequestImpl extends AbstractPageRequest
{
    /**
     * @var Sort
     */
    private $sort;
    
    /**
     * Creates a new {@link PageRequest}. Pages are zero indexed, thus providing 0 for {@code page} will return the first
     * page.
     *
     * @param int $page zero-based page index.
     * @param int $size the size of the page to be returned.
     * @param Sort $sort
     */
    public function  __construct(int $page, int $size, Sort $sort=null)
    {
        parent::__construct($page, $size);
        if ( null === $sort){
            return;
        }else{
            $this->sort = $sort;
        }
    }
    
    public function getSort() : Sort {
        return $this->sort;
    }
    
    public function next() : PageableInterface {
        return new PageRequestImpl($this->getPageNumber() + 1, $this->getPageSize(), $this->getSort());
    }
    
    public function previous() : PageableInterface{
        return $this->getPageNumber()==0 ? $this : new PageRequestImpl($this->getPageNumber()-1, $this->getPageSize(), $this->getSort());
    }

    public function first() : PageableInterface {
        return new PageRequestImpl(0, $this->getPageSize(), $this->getSort());
    }
    
    
    public function  __toString(){
        return sprintf('Page request [number: %d, size %d, sort: %s]', $this->getPageNumber(), $this->getPageSize(), $this->sort==null ? null : $this->sort);
    }
    
}
