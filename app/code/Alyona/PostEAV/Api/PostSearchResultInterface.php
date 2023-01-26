<?php

namespace Alyona\PostEAV\Api;

interface PostSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Alyona\PostEAV\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * @param \Alyona\PostEAV\Api\Data\PostInterface[]
     * @return void
     */
    public function setItems(array $items);
}
