<?php

namespace Alyona\PostEAV\Api;

interface CommentSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Alyona\PostEAV\Api\Data\CommentInterface[]
     */
    public function getItems();

    /**
     * @param \Alyona\PostEAV\Api\Data\CommentInterface[] $items
     * @return void
     */
    public function setItems(array $items);

}
