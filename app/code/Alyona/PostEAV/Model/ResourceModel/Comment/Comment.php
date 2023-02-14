<?php

namespace Alyona\PostEAV\Model\ResourceModel\Comment;

use Magento\Framework\Model\ResourceModel\Db\Context;

class Comment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }


    protected function _construct()
    {
        $this->_init('alyona_posteav_comments', 'comment_id');
    }
}
