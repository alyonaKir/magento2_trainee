<?php

namespace Alyona\PostEAV\Model\ResourceModel\Comment;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'comment_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('Alyona\PostEAV\Model\Comment', 'Alyona\PostEAV\Model\ResourceModel\Comment\Comment');
    }
}
