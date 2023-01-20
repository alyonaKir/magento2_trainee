<?php

namespace Alyona\PostEAV\Model\ResourceModel\Post\Grid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'alyona_posteav_collection';
    protected $_eventObject = 'posteav_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('Alyona\PostEAV\Model\Post', 'Alyona\PostEAV\Model\ResourceModel\Post');
    }
}
