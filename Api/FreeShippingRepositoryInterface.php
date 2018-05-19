<?php

namespace Yogesh\FreeShipping\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * FreeShipping CRUD interface.
 * @api
 */
interface FreeShippingRepositoryInterface
{
    /**
     * Save FreeShipping Item.
     *
     * @param \Yogesh\FreeShipping\Api\Data\FreeShippingInterface $freeShipping
     * @return \Yogesh\FreeShipping\Api\Data\FreeShippingInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\FreeShippingInterface $freeShipping);

    /**
     * Retrieve FreeShipping Item by city_id.
     *
     * @param int $cityId
     * @return \Yogesh\FreeShipping\Api\Data\FreeShippingInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($cityId);

    /**
     * Retrieve FreeShipping Item matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Yogesh\FreeShipping\Api\Data\FreeShippingSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete FreeShipping Item.
     *
     * @param \Yogesh\FreeShipping\Api\Data\FreeShippingInterface $freeShipping
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\FreeShippingInterface $freeShipping);

    /**
     * Delete FreeShipping Item by ID.
     *
     * @param int $cityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($cityId);
}