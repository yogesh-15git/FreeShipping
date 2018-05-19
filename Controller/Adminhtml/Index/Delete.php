<?php

namespace Yogesh\FreeShipping\Controller\Adminhtml\Index;

class Delete extends \Yogesh\FreeShipping\Controller\Adminhtml\FreeShipping
{
    /**
     * @var \Yogesh\FreeShipping\Api\FreeShippingRepositoryInterface
     * */
    protected $_freeShippingRepository;

    /**
     * @param \Magento\Backend\App\Action\Context                      $context
     * @param \Magento\Framework\Registry                              $coreRegistry
     * @param \Yogesh\FreeShipping\Api\FreeShippingRepositoryInterface $freeShippingRepository
     * */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Yogesh\FreeShipping\Api\FreeShippingRepositoryInterface $freeShippingRepository
    )
    {
        parent::__construct($context, $coreRegistry);
        $this->_freeShippingRepository = $freeShippingRepository;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('city_id');
        if($id)
        {
            try
            {
                $this->_freeShippingRepository->deleteById($id);

                $this->messageManager->addSuccessMessage(__('You deleted the City.'));

                return $resultRedirect->setPath('*/*/');
            }
            catch (\Exception $e)
            {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['city_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a city to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
