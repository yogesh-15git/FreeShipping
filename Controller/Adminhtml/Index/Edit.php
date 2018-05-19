<?php

namespace Yogesh\FreeShipping\Controller\Adminhtml\Index;

use Yogesh\FreeShipping\Api\FreeShippingRepositoryInterface;

class Edit extends \Yogesh\FreeShipping\Controller\Adminhtml\FreeShipping
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var FreeShippingRepositoryInterface
     * */
    protected $freeShippingRepository;

    /**
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\Registry                $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param FreeShippingRepositoryInterface            $freeShippingRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        FreeShippingRepositoryInterface $freeShippingRepository
    )
    {
        $this->resultPageFactory      = $resultPageFactory;
        $this->freeShippingRepository = $freeShippingRepository;
        parent::__construct($context, $coreRegistry);
    }


    /**
     * Edit FreeShipping City
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('city_id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if($id)
        {
            $city = $this->freeShippingRepository->getById($id);
            if(!$city->getCityId())
            {
                $this->messageManager->addErrorMessage(__('This city is no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $this->_coreRegistry->register('yogesh_freeshipping', $city);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit City') : __('New City'),
            $id ? __('Edit City') : __('New City')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Free Shipping City'));
        $resultPage->getConfig()->getTitle()->prepend($id ? $city->getCityName() : __('New City'));
        return $resultPage;
    }
}
