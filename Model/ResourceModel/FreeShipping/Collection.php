<?php

namespace Yogesh\FreeShipping\Model\ResourceModel\FreeShipping;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'city_id';


    protected function _construct()
    {
        $this->_init('Yogesh\FreeShipping\Model\FreeShipping', 'Yogesh\FreeShipping\Model\ResourceModel\FreeShipping');
    }
}