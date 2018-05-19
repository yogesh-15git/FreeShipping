<?php

namespace Yogesh\FreeShipping\Model;

use Yogesh\FreeShipping\Api\Data\FreeShippingInterface;

class FreeShipping extends \Magento\Framework\Model\AbstractModel implements FreeShippingInterface
{
    /**
     * FreeShipping cache tag.
     */
    const CACHE_TAG = 'free_shipping';

    /**
     * @var string
     */
    protected $_cacheTag = 'free_shipping';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'free_shipping';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Yogesh\FreeShipping\Model\ResourceModel\FreeShipping');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getCityId()];
    }

    /**
     * {@inheritdoc}
     */
    public function getCityId()
    {
        return $this->getData(self::CITY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCityId($cityId)
    {
        return $this->getData(self::CITY_ID, $cityId);
    }

    /**
     * {@inheritdoc}
     */
    public function getCityName()
    {
        return $this->getData(self::CITY_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setCityName($cityName)
    {
        return $this->getData(self::CITY_NAME, $cityName);
    }

    /**
     * {@inheritdoc}
     */
    public function getCityMinimumAmount()
    {
        return $this->getData(self::CITY_MINIMUM_AMOUNT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCityMinimumAmount($cityMinimumAmount)
    {
        return $this->getData(self::CITY_MINIMUM_AMOUNT, $cityMinimumAmount);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsActive($isActive)
    {
        return $this->getData(self::IS_ACTIVE, $isActive);
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreId($storeId)
    {
        return $this->getData(self::STORE_ID, $storeId);
    }
}