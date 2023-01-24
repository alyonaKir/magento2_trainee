<?php

namespace Alyona\PostEAV\Model;

class Tag extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'alyona_posteav';

    protected $_cacheTag = 'alyona_posteav';

    protected $_eventPrefix = 'alyona_posteav';

    protected function _construct()
    {
        $this->_init('Alyona\PostEAV\Model\ResourceModel\Tag\Tag');
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
        return $this->getData('tag_id');
    }
}
