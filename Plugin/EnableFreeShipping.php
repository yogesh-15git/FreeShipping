<?php

namespace Yogesh\FreeShipping\Plugin;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Yogesh\FreeShipping\Model\ResourceModel\FreeShipping\CollectionFactory;

class EnableFreeShipping
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var CollectionFactory
     */
    protected $cityCollection;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;


    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        ProductRepositoryInterface $productRepository,
        CollectionFactory $cityCollection,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_checkoutSession  = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->cityCollection    = $cityCollection;
        $this->_storeManager     = $storeManager;
    }

    public function afterCollectRates(\Magento\OfflineShipping\Model\Carrier\Freeshipping $subject, $result, RateRequest $request)
    {
        if($productCondition = $this->_checkFreeShippingAvailableForProduct())
        {
            return $result;
        }

        if($cityCondition = $this->_checkFreeShippingAvailableForCity())
        {
            return $result;
        }
        return FALSE;
    }

    /**
     * check if ordered item fulfill the minimum quantity condition for free shipping
     *
     * @return bool
     */
    private function _checkFreeShippingAvailableForProduct()
    {
        $result = FALSE;

        $items = $this->_checkoutSession->getQuote()->getAllItems();

        /** @var \Magento\Quote\Model\ResourceModel\Quote\Item $item */
        foreach ($items as $item)
        {
            $product     = $this->productRepository->getById($item->getProductId());
            $minQuantity = $product->getMinQuantityForFreeShipping();
            $qty         = $item->getQty();
            if($qty >= $minQuantity)
            {
                $result = TRUE;
                break;
            }
        }
        return $result;
    }

    private function _checkFreeShippingAvailableForCity()
    {
        $shippingCity = $this->_checkoutSession->getQuote()->getShippingAddress()->getCity();
        if(is_null($shippingCity) || !$shippingCity)
        {
            return FALSE;
        }

        $availableCities = $this->_getAvailableCities();
        if(count($availableCities->getData()) <= 0)
        {
            return FALSE;
        }

        $cities = array();
        /** @var \Yogesh\FreeShipping\Model\FreeShipping $city */
        foreach ($availableCities as $city)
        {
            $cities[] = strtolower($city->getCityName());
        }

        if(in_array(strtolower($shippingCity), $cities))
        {
            $minimumAmount = $availableCities->addFieldToFilter('city_name', array('LIKE' => strtolower($shippingCity)))->getFirstItem()->getCityMinimumAmount();
            if($this->_checkoutSession->getQuote()->getSubtotal() >= $minimumAmount)
            {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function _getAvailableCities()
    {
        $cities = $this->cityCollection
            ->create()
            ->addFilter('main_table.is_active', 1)
            ->addFieldToFilter(['store_id', 'store_id'],
                [
                    ['finset' => 0],
                    ['finset' => $this->_storeManager->getStore()->getId()]
                ]);

        return $cities;
    }
}