<?php
namespace DoctrineData\Pagination;
use DoctrineData\Pagination\Sorting\Order;
use DoctrineData\Pagination\Sorting\Direction;
use PhpCommonUtil\Util\Assert;
use Zend\Stdlib\ArrayUtils;

class Sort implements \IteratorAggregate
{
    
    /**
     * 
     * @var Order[]
     */
    private $orders;

    /**
     * Sort constructor.
     * @param Direction $direction
     * @param \string[] ...$properties
     */
    public function __construct(Direction $direction, string... $properties)
    {
        Assert::hasLength($properties, "You have to provide at least one sort property to sort by!");
        $this->orders = array();
        foreach ($properties as $property) {
            $this->orders[] = new Order($property, $direction);
        }
    }
    
    /**
     * @param Sort sort can be {@literal null}.
     * @return Sort
     */
    public function andSort (Sort $sort) : self
    {
        $this->orders = ArrayUtils::merge($this->orders, $sort->getOrders());
        return $this;
    }

    /**
     *  Add order into current sort
     * @param Order $order
     * @return Sort
     */
    public function andOrder(Order $order) : self
    {
        $this->orders[] = $order;
        return $this;
    }
    
    /**
     * Returns the order registered for the given property.
     *
     * @param string $property
     * @return Order
     */
    public function  getOrderFor(string $property) : Order
    {
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

    /**
     * @return Order[]
     */
    public function getOrders() : array{
        return $this->orders;
    }
    
    
}