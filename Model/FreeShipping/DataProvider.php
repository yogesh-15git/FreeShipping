<?php

namespace Yogesh\FreeShipping\Model\FreeShipping;

use Yogesh\FreeShipping\Model\ResourceModel\FreeShipping\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Yogesh\FreeShipping\Model\ResourceModel\FreeShipping\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string                 $name
     * @param string                 $primaryFieldName
     * @param string                 $requestFieldName
     * @param CollectionFactory      $freeShippingCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array                  $meta
     * @param array                  $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $freeShippingCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection    = $freeShippingCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if(isset($this->loadedData))
        {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Yogesh\FreeShipping\Model\FreeShipping $city */
        foreach ($items as $city)
        {
            $this->loadedData[$city->getCityId()] = $city->getData();
        }

        $data = $this->dataPersistor->get('yogesh_freeshipping');
        if(!empty($data))
        {
            $city = $this->collection->getNewEmptyItem();
            $city->setData($data);
            $this->loadedData[$city->getCityId()] = $city->getData();
            $this->dataPersistor->clear('yogesh_freeshipping');
        }

        return $this->loadedData;
    }
}
