<?php

namespace Alyona\Post\Model\ResourceModel\Post;

use Alyona\Post\Model\Post;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Alyona\Post\Model\ResourceModel\Post as PostResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
       $this->_init(Post::class, PostResource::class);
    }
}
