<?php

namespace Yogesh\FreeShipping\Controller\Adminhtml\Index;

class Index extends \Yogesh\FreeShipping\Controller\Adminhtml\FreeShipping
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     * */
    protected $_dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context                   $context
     * @param \Magento\Framework\Registry                           $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory            $resultPageFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataPersistor     = $dataPersistor;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Grid List page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Free Shipping'));

        $this->_dataPersistor->clear('yogesh_freeshipping');

        return $resultPage;
    }
}