<?php

namespace Yogesh\FreeShipping\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Yogesh\FreeShipping\Api\FreeShippingRepositoryInterface as FreeShippingRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Yogesh\FreeShipping\Api\Data\FreeShippingInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var FreeShippingRepository */
    protected $freeShippingRepository;

    /** @var JsonFactory */
    protected $jsonFactory;

    /**
     * @param Context                $context
     * @param FreeShippingRepository $freeShippingRepository
     * @param JsonFactory            $jsonFactory
     */
    public function __construct(
        Context $context,
        FreeShippingRepository $freeShippingRepository,
        JsonFactory $jsonFactory
    )
    {
        parent::__construct($context);
        $this->freeShippingRepository = $freeShippingRepository;
        $this->jsonFactory            = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error      = FALSE;
        $messages   = [];

        if($this->getRequest()->getParam('isAjax'))
        {
            $postItems = $this->getRequest()->getParam('items', []);
            if(!count($postItems))
            {
                $messages[] = __('Please correct the data sent.');
                $error      = TRUE;
            }
            else
            {
                foreach (array_keys($postItems) as $cityId)
                {
                    /** @var \Yogesh\FreeShipping\Model\FreeShipping $city */
                    $city = $this->freeShippingRepository->getById($cityId);
                    try
                    {
                        $city->setData(array_merge($city->getData(), $postItems[$cityId]));
                        $this->freeShippingRepository->save($city);
                    }
                    catch (\Exception $e)
                    {
                        $messages[] = $this->getErrorWithCityId(
                            $city,
                            __($e->getMessage())
                        );
                        $error      = TRUE;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error'    => $error
        ]);
    }

    /**
     * Add City ID to error message
     *
     * @param FreeShippingInterface $city
     * @param string                $errorText
     * @return string
     */
    protected function getErrorWithCityId(FreeShippingInterface $city, $errorText)
    {
        return '[City ID: ' . $city->getCityId() . '] ' . $errorText;
    }
}
