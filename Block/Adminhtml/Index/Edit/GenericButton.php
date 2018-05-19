<?php

namespace Yogesh\FreeShipping\Block\Adminhtml\Index\Edit;

use Magento\Backend\Block\Widget\Context;
use Yogesh\FreeShipping\Api\FreeShippingRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var FreeShippingRepositoryInterface
     */
    protected $freeShippingRepository;

    /**
     * @param Context                         $context
     * @param FreeShippingRepositoryInterface $freeShippingRepository
     */
    public function __construct(
        Context $context,
        FreeShippingRepositoryInterface $freeShippingRepository
    )
    {
        $this->context                = $context;
        $this->freeShippingRepository = $freeShippingRepository;
    }

    /**
     * Return City ID
     *
     * @return int|null
     */
    public function getCityId()
    {
        try
        {
            return $this->freeShippingRepository->getById(
                $this->context->getRequest()->getParam('city_id')
            )->getCityId();
        }
        catch (NoSuchEntityException $e)
        {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array  $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
