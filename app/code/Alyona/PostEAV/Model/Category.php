<?php

namespace Alyona\PostEAV\Model;

class Category extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'alyona_posteav';

    protected $_cacheTag = 'alyona_posteav';

    protected $_eventPrefix = 'alyona_posteav';

    protected function _construct()
    {
        $this->_init('Alyona\PostEAV\Model\ResourceModel\Category\Category');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    public function getId()
    {
        return $this->getData('category_id');
    }
}
