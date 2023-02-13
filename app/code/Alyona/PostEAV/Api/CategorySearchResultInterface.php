<?php

namespace Alyona\PostEAV\Api;

interface CategorySearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Alyona\PostEAV\Api\Data\CategoryInterface[]
     */
    public function getItems();

    /**
     * @param \Alyona\PostEAV\Api\Data\CategoryInterface[] $items
     * @return void
     */
    public function setItems(array $items);

}
