<?php

namespace Yogesh\FreeShipping\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Yogesh\FreeShipping\Api\FreeShippingRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Yogesh\FreeShipping\Api\Data\FreeShippingInterface;

class Save extends \Yogesh\FreeShipping\Controller\Adminhtml\FreeShipping
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var FreeShippingRepositoryInterface
     * */
    protected $freeShippingRepository;

    /**
     * @var FreeShippingInterface
     */
    protected $freeShipping;

    /**
     * @param Context                         $context
     * @param \Magento\Framework\Registry     $coreRegistry
     * @param DataPersistorInterface          $dataPersistor
     * @param FreeShippingRepositoryInterface $freeShippingRepository
     * @param FreeShippingInterface           $freeShipping
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        FreeShippingRepositoryInterface $freeShippingRepository,
        FreeShippingInterface $freeShipping
    )
    {
        $this->dataPersistor          = $dataPersistor;
        $this->freeShippingRepository = $freeShippingRepository;
        $this->freeShipping           = $freeShipping;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if($data)
        {
            $id = $this->getRequest()->getParam('city_id');

            if(isset($data['is_active']) && $data['is_active'] === 'true')
            {
                $data['is_active'] = \Magento\Cms\Model\Block::STATUS_ENABLED;
            }
            if(empty($data['city_id']))
            {
                $data['city_id'] = null;
            }

            $data['store_id'] = implode(',', $data['store_id']);

            if($id)
            {
                $city = $this->freeShippingRepository->getById($id);
                if(!$city->getCityId())
                {
                    $this->messageManager->addErrorMessage(__('This City no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
                $city->setData($data);
            }
            else
            {
                $city = $this->freeShipping->setData($data);
            }

            try
            {
                $this->freeShippingRepository->save($city);
                $this->messageManager->addSuccessMessage(__('City has been saved.'));
                $this->dataPersistor->clear('yogesh_freeshipping');

                if($this->getRequest()->getParam('back'))
                {
                    return $resultRedirect->setPath('*/*/edit', ['city_id' => $city->getCityId()]);
                }
                return $resultRedirect->setPath('*/*/');
            }
            catch (LocalizedException $e)
            {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
            catch (\Exception $e)
            {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the city.'));
            }

            $this->dataPersistor->set('yogesh_freeshipping', $data);
            return $resultRedirect->setPath('*/*/edit', ['city_id' => $this->getRequest()->getParam('city_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
