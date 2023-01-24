<?php

namespace Alyona\PostEAV\Model\ResourceModel\Tag;

use Magento\Framework\Model\ResourceModel\Db\Context;

class Tag extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }


    protected function _construct()
    {
        $this->_init('alyona_posteav_tags', 'tag_id');
    }
}
