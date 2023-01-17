<?php

namespace Alyona\Post\Model\ResourceModel;

use Alyona\Post\Api\Data\PostInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;


class Post extends AbstractDb
{
    public const TABLE_NAME = 'alyona_post';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('alyona_post', 'post_id');
    }

}
