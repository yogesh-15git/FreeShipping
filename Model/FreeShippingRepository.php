<?php

namespace Yogesh\FreeShipping\Model;

use Yogesh\FreeShipping\Api\Data;
use Yogesh\FreeShipping\Api\FreeShippingRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Yogesh\FreeShipping\Model\ResourceModel\FreeShipping as ResourceFreeShipping;
use Yogesh\FreeShipping\Model\ResourceModel\FreeShipping\CollectionFactory as FreeShippingCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class FreeShippingRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FreeShippingRepository implements FreeShippingRepositoryInterface
{
    /**
     * @var ResourceFreeShipping
     */
    protected $resource;

    /**
     * @var FreeShippingFactory
     */
    protected $freeShippingFactory;

    /**
     * @var FreeShippingCollectionFactory
     */
    protected $freeShippingCollectionFactory;

    /**
     * @var Data\FreeShippingSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var Data\FreeShippingInterfaceFactory
     */
    protected $dataFreeShippingFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param ResourceFreeShipping                           $resource
     * @param FreeShippingFactory                            $freeShippingFactory
     * @param FreeShippingCollectionFactory                  $freeShippingCollectionFactory
     * @param Data\FreeShippingSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                               $dataObjectHelper
     * @param DataObjectProcessor                            $dataObjectProcessor
     * @param Data\FreeShippingInterfaceFactory              $dataFreeShippingFactory
     * @param StoreManagerInterface                          $storeManager
     * */
    public function __construct(
        ResourceFreeShipping $resource,
        FreeShippingFactory $freeShippingFactory,
        FreeShippingCollectionFactory $freeShippingCollectionFactory,
        Data\FreeShippingSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        Data\FreeShippingInterfaceFactory $dataFreeShippingFactory,
        StoreManagerInterface $storeManager
    )
    {
        $this->resource                      = $resource;
        $this->freeShippingFactory           = $freeShippingFactory;
        $this->freeShippingCollectionFactory = $freeShippingCollectionFactory;
        $this->searchResultsFactory          = $searchResultsFactory;
        $this->dataObjectHelper              = $dataObjectHelper;
        $this->dataObjectProcessor           = $dataObjectProcessor;
        $this->dataFreeShippingFactory       = $dataFreeShippingFactory;
        $this->storeManager                  = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Data\FreeShippingInterface $freeShipping)
    {
        try
        {
            $this->resource->save($freeShipping);
        }
        catch (\Exception $exception)
        {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $freeShipping;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($cityId)
    {
        $city = $this->freeShippingFactory->create();
        $this->resource->load($city, $cityId);
        if(!$city->getCityId())
        {
            throw new NoSuchEntityException(__('City with id "%1" does not exist.', $cityId));
        }
        return $city;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $collection = $this->freeShippingCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup)
        {
            foreach ($filterGroup->getFilters() as $filter)
            {
                if($filter->getField() === 'store_id')
                {
                    $collection->addStoreFilter($filter->getValue(), FALSE);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $sortOrders = $criteria->getSortOrders();
        if($sortOrders)
        {
            foreach ($sortOrders as $sortOrder)
            {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $collection->load();

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Data\FreeShippingInterface $freeShipping)
    {
        try
        {
            $this->resource->delete($freeShipping);
        }
        catch (\Exception $exception)
        {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return TRUE;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($cityId)
    {
        return $this->delete($this->getById($cityId));
    }
}