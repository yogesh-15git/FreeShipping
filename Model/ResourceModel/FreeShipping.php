<?php

namespace Yogesh\FreeShipping\Model\ResourceModel;

/**
 * FreeShipping mysql resource.
 */
class FreeShipping extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'city_id';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('yogesh_freeshipping', 'city_id');
    }
}