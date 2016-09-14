<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 09/06/2016
 * Time: 3:48 AM
 */

namespace DoctrineData\Repository\Support;


use Doctrine\ORM\QueryBuilder;
use DoctrineData\Pagination\PageableInterface;
use Doctrine\ORM\Query;
use DoctrineData\Pagination\Page;
use DoctrineData\Pagination\PageInterface;
use DoctrineData\Pagination\Sort;
use DoctrineData\Pagination\Sorting\NullHandling;
use DoctrineData\Pagination\Sorting\Order;
use PhpCommonUtil\Util\Assert;

trait PaginationSupport
{

    use ConstructorSupport;

    /**
     *
     * @param QueryBuilder $qb
     * @param object $pageableOrSort
     * @param string $alias
     * @param int $hydrationMode
     * @return PageableInterface|array
     */
    protected final function processPageableOrSorting(QueryBuilder $qb, $pageableOrSort, $alias = 'e', $hydrationMode = null){

        if ( $pageableOrSort instanceof Sort ) {
            return $this->processSorting($qb, $pageableOrSort, $alias)->getQuery()->getResult($hydrationMode);
        }else if ($pageableOrSort instanceof PageableInterface ){
            return $this->processPageable($qb, $pageableOrSort, $alias, $hydrationMode);
        }
        //FIXME change exception class
        throw new \RuntimeException(sprintf('$pageableOrSort must be instanceof \'%s\' or \'%s\'', PageableInterface::class, Sort::class));
    }

    /**
     * Append query spec from Sort into QueryBuilder
     * @param QueryBuilder $qb
     * @param Sort $sort
     * @param string $alias
     * @return QueryBuilder
     * @throws \InvalidArgumentException
     */
    protected final function processSorting(QueryBuilder $qb, Sort $sort, $alias = 'e')
    {
        Assert::notNull($qb);
        Assert::notNull($sort);
        foreach ($sort as $order) {
            /* @var $order Order */
            $direction = $order->getDirection()->getValue();
            $nullHandling = $order->getNullHandling();
            $property = $order->getProperty();
            $nullHandlingString = null;
            switch ($nullHandling->getValue()) {
                case NullHandling::NATIVE:
                    $nullHandlingString = '';
                    break;
                case NullHandling::NULLS_FIRST:
                    $nullHandlingString = ' NULLS FIRST';
                    break;
                case NullHandling::NULLS_LAST:
                    $nullHandlingString = ' NULLS LAST';
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid Null Handling value which not match any switch case: ' . $nullHandling->getValue());
            }
            $qb->addOrderBy("{$alias}.{$property}", $direction . $nullHandlingString);
        }
        return $qb;
    }

    /**
     * Append query spec from PageableInterface into QueryBuilder
     * @param QueryBuilder $qb
     * @param string $alias
     * @return integer total elements
     * @throws \InvalidArgumentException
     */
    protected final function countTotalElements(QueryBuilder $qb, string $alias = 'e')
    {
        /* @var $select Query\Expr\Select */
        $selectList = $qb->getDQLPart('select');
        $qb->resetDQLPart('select');
        $qb->select("count({$alias})");
        $total = $qb->getQuery()->getSingleScalarResult();
        $qb->resetDQLPart('select');

        foreach($selectList as $select){
            $qb->addSelect($select->getParts());
        }

        return $total;
    }

    /**
     * Append query spec from PageableInterface into QueryBuilder
     * @param QueryBuilder $qb
     * @param PageableInterface $pageable
     * @param string $alias
     * @param int $hydrationMode
     * @return PageInterface
     * @throws \InvalidArgumentException
     */
    protected final function processPageable(QueryBuilder $qb, PageableInterface $pageable, $alias = 'e', $hydrationMode = null)
    {

        $total = $this->countTotalElements($qb);

        $sort = $pageable->getSort();
        if( null !== $sort){
            $this->processSorting($qb, $sort, $alias);
        }
        $qb->setMaxResults($pageable->getPageSize());
        $qb->setFirstResult($pageable->getPageSize() * $pageable->getPageNumber());

        $content = $qb->getQuery()->getResult($hydrationMode);
        $page = new Page($content, $pageable, $total);
        return $page;
    }


}