<?php
namespace MkDoctrineSpringData\Pagination;
use MkDoctrineSpringData\Pagination\Sorting\Order;
use MkDoctrineSpringData\Pagination\Sorting\Direction;
use PhpCommonUtil\Util\Assert;

class Sort implements \IteratorAggregate, PageableOrSort
{
    
    /**
     * 
     * @var Order[]
     */
    private $orders;

    /**
     * 
     * @param Direction $defaultDirection
     * @param string $ordersOrProperty
     */
    public function __construct($direction, $ordersOrProperty)
    {
        Assert::hasLength($ordersOrProperty, "You have to provide at least one sort property to sort by!");
        $this->orders = array();
        $this->orders[] = new Order($direction, $ordersOrProperty);
    }
    
    
    /**
     * Returns a new {@link Sort} consisting of the {@link Order}s of the current {@link Sort} combined with the given
     * ones.
     *
     * @param Sort sort can be {@literal null}.
     * @return Sort
     */
    public function andSort (Sort $sort) {
    
        $this->orders = array_merge($this->orders , $sort->getIterator()->getArrayCopy());
        return $this;
        
    }
    
    /**
     * Returns the order registered for the given property.
     *
     * @param property
     * @return Order
     */
    public function  getOrderFor($property) {
        
        foreach ($this->orders as $order){
            if($order->getProperty() == $property){
                return $order;
            }
        }
        return null;
    }
    
    
    public function getIterator() {
        Assert::notEmpty($this->orders, "This Sort is not initialized yet.");
        return new \ArrayIterator($this->orders);
    }
    
    
}