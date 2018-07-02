<?php

namespace Yogesh\FreeShipping\Model\ResourceModel\FreeShipping\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Yogesh\FreeShipping\Model\ResourceModel\FreeShipping\Collection as FreeShippingCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use \Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Class Collection
 * Collection for displaying grid
 */
class Collection extends FreeShippingCollection implements SearchResultInterface
{
    protected $authSession;

    /**
     * Resource initialization
     * @param EntityFactoryInterface $entityFactory ,
     * @param LoggerInterface        $logger ,
     * @param FetchStrategyInterface $fetchStrategy ,
     * @param ManagerInterface       $eventManager ,
     * @param String                 $mainTable ,
     * @param String                 $eventPrefix ,
     * @param String                 $eventObject ,
     * @param String                 $resourceModel ,
     * @param                        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
     * @param AdapterInterface       $connection = null,
     * @param AbstractDb             $resource = null
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        \Magento\Backend\Model\Auth\Session $authSession,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    )
    {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->authSession = $authSession;
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     *
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null
    )
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * This is the function that will add the filter
     */
    protected function _beforeLoad()
    {
        parent::_beforeLoad();
        $this->addFieldToFilter('city_name',['like' => $this->getCurrentAdminUserCity()]);
        return $this;
    }

    public function getCurrentAdminUserCity()
    {
        return $this->authSession->getUser()->getCity(); // replace getCity() to you column
    }
}
