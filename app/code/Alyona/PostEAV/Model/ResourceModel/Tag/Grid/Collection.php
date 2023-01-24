<?php

namespace Alyona\PostEAV\Model\ResourceModel\Tag\Grid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'tag_id';
    protected $_eventPrefix = 'alyona_posteav_tag_collection';
    protected $_eventObject = 'posteav_tag_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('Alyona\PostEAV\Model\Tag', 'Alyona\PostEAV\Model\ResourceModel\Tag\Tag');
    }
}
