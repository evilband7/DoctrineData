<?php
namespace DoctrineData\Pagination;
use JMS\Serializer\Annotation as Serializer;

class PageImpl extends Chunk implements PageInterface
{
    /**
     * @var int
     */
    private $total;
    
    /**
     * Constructor of {@code PageImpl}.
     *
     * @param array $content the content of this page, must not be {@literal null}.
     * @param PageableInterface $pageable the paging information, can be {@literal null}.
     * @param int $total the total amount of items available
     */
    public function __construct(array $content, PageableInterface $pageable = NULL, int $total = 0) {
        $total = null===$total ? (null===$content ? 0 : count($content) ) :$total;
        parent::__construct($content, $pageable);
        $this->total = $total;
    }
    
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("totalPages")
     */
    public function  getTotalPages() : int
    {
        return $this->getSize() == 0 ? 1 : ceil($this->total/$this->getSize());
    }
    
    /**
     * @see \DoctrineData\Pagination\PageInterface::getTotalElements()
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("totalElements")
     * 
     */
    public function getTotalElements() : int
    {
        return $this->total;
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("hasNext")
     */
    public function  hasNext() : bool
    {
        return ( $this->getNumber() + 1 ) < $this->getTotalPages();
    }
    
    
    public function  __toString(){
        $contentType = 'UNKNOWN';
        if( count($this->content) > 0 ){
            $contentType = get_class( $this->content[0] );
        }
        return sprintf("Page %s of %d containing %s instances", $this->getNumber(), $this->getTotalPages(), $contentType);
    }

}