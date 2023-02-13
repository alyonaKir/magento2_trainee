<?php

namespace Alyona\PostEAV\Api;

use Alyona\PostEAV\Api\Data\PostInterface;

interface PostSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Alyona\PostEAV\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * @param \Alyona\PostEAV\Api\Data\PostInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
