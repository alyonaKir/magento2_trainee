<?php

namespace Alyona\PostEAV\Model\ResourceModel\Category\Grid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'category_id';
    protected $_eventPrefix = 'alyona_posteav_category_collection';
    protected $_eventObject = 'posteav_category_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('Alyona\PostEAV\Model\Category', 'Alyona\PostEAV\Model\ResourceModel\Category\Category');
    }
}
