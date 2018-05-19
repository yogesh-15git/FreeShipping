<?php

namespace Yogesh\FreeShipping\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for FreeShipping search results.
 * @api
 */
interface FreeShippingSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get FreeShipping list.
     *
     * @return \Yogesh\FreeShipping\Api\Data\FreeShippingInterface[]
     */
    public function getItems();

    /**
     * Set FreeShipping list.
     *
     * @param \Yogesh\FreeShipping\Api\Data\FreeShippingInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
