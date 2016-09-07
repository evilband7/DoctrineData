<?php

namespace  DoctrineData\Pagination\Sorting;

use PhpCommonUtil\Util\StringUtils;
use PhpCommonUtil\Util\Assert;

class Order
{
    
    const DEFAULT_DIRECTION = Direction::ASC;
    
    private static $DEFAULT_IGNORE_CASE = false;
    /**
     * 
     * @var Direction
     */
    private $direction;
    
    /**
     * 
     * @var string
     */
    private $property;
    
    /**
     * 
     * @var bool
     */
    private $ignoreCase;
    
    /**
     * 
     * @var NullHandling
     */
    private $nullHandling;
    
    /**
     * Creates a new {@link Order} instance. if order is {@literal null} then order defaults to
     * {@link Sort#DEFAULT_DIRECTION}
     *
     * @param Direction $direction can be {@literal null}, will default to {@link Sort#DEFAULT_DIRECTION}
     * @param string $property must not be {@literal null} or empty.
     */

    /**
     * Creates a new {@link Order} instance.
     * @param Direction $direction
     * @param string $property
     * @param bool|null $ignoreCase
     * @param NullHandling|null $nullHandling
     */
    public function  __construct(string $property, Direction $direction = null, boolean $ignoreCase = null, NullHandling $nullHandling = null)
    {
        Assert::isTrue(StringUtils::hasText($property), "Property must not blank !");
        $this->property = $property;
        $this->direction = null == $direction ? new Direction(self::DEFAULT_DIRECTION) : $direction;
        $this->ignoreCase = $ignoreCase === null ? self::$DEFAULT_IGNORE_CASE : $ignoreCase ;
        $this->nullHandling = null == $nullHandling ? new NullHandling(NullHandling::NATIVE) : $nullHandling;
    }
    
    
    /**
     * Returns the order the property shall be sorted for.
     *
     * @return Direction
     */
    public function  getDirection() : Direction{
        return $this->direction;
    }
    
    /**
     * Returns the property to order for.
     *
     * @return string
     */
    public function  getProperty() : string {
        return $this->property;
    }
    
    /**
     * Returns whether sorting for this property shall be ascending.
     *
     * @return boolean
     */
    public function isAscending() {
        return $this->direction->getValue() === Direction::ASC;
    }
    
    /**
     * Returns whether or not the sort will be case sensitive.
     *
     * @return boolean
     */
    public function isIgnoreCase() {
        return $this->ignoreCase;
    }

    /**
     * Returns the used {@link NullHandling} hint, which can but may not be respected by the used data store.
     *
     * @return NullHandling
     * @since 1.7
     */
    public function getNullHandling() {
        return $this->nullHandling;
    }
    
//    /**
//     *
//     * @param Direction|NullHandling  $directionOrNullHandling
//     */
//    public function with($directionOrNullHandling){
//        if( $directionOrNullHandling instanceof Direction ){
//            return $this->withDirection($directionOrNullHandling);
//        }else if($directionOrNullHandling instanceof NullHandling){
//            return $this->withNullHandling($directionOrNullHandling);
//        }else{
//            $given = is_object($directionOrNullHandling) ? get_class($directionOrNullHandling) : ( is_array($directionOrNullHandling) ? 'array' : 'mixed[value="'.$directionOrNullHandling.'"]');
//            throw new \UnexpectedValueException('Expect $directionOrNullHandling to be Direction or NullHandling but ' . $given . ' given.');
//        }
//    }

//    /**
//     * Returns a new {@link Order} with the given {@link Order}.
//     *
//     * @param order
//     * @return Order
//     */
//    private function withDirection(Direction $direction) {
//        return new Order($direction, $this->property, $this->nullHandling);
//    }
//
//    /**
//     * Returns a new {@link Sort} instance for the given properties.
//     *
//     * @param properties
//     * @return Sort
//     */
//    public function withProperties(array $properties) {
//        return new Sort($this->direction, $properties);
//    }
    
//    /**
//     * Returns a new {@link Order} with case insensitive sorting enabled.
//     *
//     * @return Order
//     */
//    public function ignoreCase() {
//        return new Order($this->direction, $this->property, true, $this->nullHandling);
//    }
    
//    /**
//     * Returns a {@link Order} with the given {@link NullHandling}.
//     *
//     * @param nullHandling can be {@literal null}.
//     * @return Order
//     * @since 1.8
//     */
//    private function  withNullHandling(NullHandling $nullHandling) {
//        return new Order($this->direction, $this->property, $this->ignoreCase, $nullHandling);
//    }
    
//    /**
//     * Returns a {@link Order} with {@link NullHandling#NULLS_FIRST} as null handling hint.
//     *
//     * @return Order
//     * @since 1.8
//     */
//    public function  nullsFirst() {
//        return $this->with(NullHandling::NULLS_FIRST());
//    }
    
//    /**
//     * Returns a {@link Order} with {@link NullHandling#NULLS_LAST} as null handling hint.
//     *
//     * @return Order
//     * @since 1.7
//     */
//    public function  nullsLast() {
//        return $this->with(NullHandling::NULLS_LAST());
//    }
    
//    /**
//     * Returns a {@link Order} with {@link NullHandling#NATIVE} as null handling hint.
//     *
//     * @return Order
//     * @since 1.7
//     */
//    public function  nullsNative() {
//        return $this->with(NullHandling::NATIVE());
//    }
    
    public function  __toString(){
        
        $result = sprintf("%s: %s", $this->property, $this->direction);
        
        if(NullHandling::NATIVE === $this->nullHandling->getValue()){
            $result .= ', ' . $this->nullHandling;
        }
    
        if ($this->ignoreCase) {
            $result .= ", ignoring case";
        }
    
        return $result;
    }
}