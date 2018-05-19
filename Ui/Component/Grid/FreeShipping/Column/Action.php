<?php

namespace Yogesh\FreeShipping\Ui\Component\Grid\FreeShipping\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class GridActions
 */
class Action extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'freeship/index/edit';
    const URL_PATH_DELETE = 'freeship/index/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Constructor
     *
     * @param ContextInterface      $context
     * @param UiComponentFactory    $uiComponentFactory
     * @param UrlInterface          $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array                 $components
     * @param array                 $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder    = $urlBuilder;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if(isset($dataSource['data']['items']))
        {
            foreach ($dataSource['data']['items'] as & $item)
            {
                if(isset($item['city_id']))
                {
                    $item[$this->getData('name')] = [
                        'edit'   => [
                            'href'  => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'city_id' => $item['city_id']
                                ]
                            ),
                            'label' => __('View')
                        ],
                        'delete' => [
                            'href'    => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'city_id' => $item['city_id']
                                ]
                            ),
                            'label'   => __('Delete'),
                            'confirm' => [
                                'title'   => __('Delete "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
