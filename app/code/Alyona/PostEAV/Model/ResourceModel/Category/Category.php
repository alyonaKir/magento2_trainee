<?php

namespace Alyona\PostEAV\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Context;

class Category extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('alyona_posteav_category', 'category_id');
    }
}
