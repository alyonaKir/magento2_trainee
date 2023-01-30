<?php

namespace Alyona\PostEAV\Model;

use Alyona\PostEAV\Api\Data\TagInterface;

class Tag extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface, TagInterface
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
        return $this->getData(TagInterface::ID);
    }

    public function setId($value)
    {
        $this->setData(TagInterface::ID, $value);
    }

    public function getName()
    {
        return $this->getData(TagInterface::NAME);
    }

    public function setName(string $name)
    {
        $this->setData(TagInterface::NAME, $name);
    }
}
