<?php

namespace Alyona\PostEAV\Api;

interface TagSearchResultInterface  extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Alyona\PostEAV\Api\Data\TagInterface[]
     */
    public function getItems();

    /**
     * @param \Alyona\PostEAV\Api\Data\TagInterface[]
     * @return void
     */
    public function setItems(array $items);

}
