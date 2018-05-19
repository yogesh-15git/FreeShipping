<?php

namespace Yogesh\FreeShipping\Api\Data;

interface FreeShippingInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const CITY_ID = 'city_id';
    const CITY_NAME = 'city_name';
    const CITY_MINIMUM_AMOUNT = 'city_minimum_amount';
    const IS_ACTIVE = 'is_active';
    const STORE_ID = 'store_id';

    /**
     * Get CityId
     *
     * @return int
     * */
    public function getCityId();

    /**
     * set CityId
     * @return $this
     * */
    public function setCityId($cityId);

    /**
     * Get CityName
     *
     * @return string
     * */
    public function getCityName();

    /**
     * set CityName
     * @return $this
     * */
    public function setCityName($cityName);

    /**
     * Get CityMinimumAmount
     *
     * @return string
     * */
    public function getCityMinimumAmount();

    /**
     * set CityMinimumAmount
     * @return $this
     * */
    public function setCityMinimumAmount($cityMinimumAmount);

    /**
     * Get IsActive
     *
     * @return string
     * */
    public function getIsActive();

    /**
     * set IsActive
     * @return $this
     * */
    public function setIsActive($isActive);

    /**
     * Get StoreId
     *
     * @return string
     * */
    public function getStoreId();

    /**
     * set StoreId
     * @return $this
     * */
    public function setStoreId($storeId);

}