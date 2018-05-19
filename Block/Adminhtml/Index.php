<?php

namespace Yogesh\FreeShipping\Block\Adminhtml;

class Index extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Yogesh_FreeShipping';
        $this->_controller = 'adminhtml_index';
        $this->_headerText = __('Free Shipping');
        parent::_construct();
    }
}