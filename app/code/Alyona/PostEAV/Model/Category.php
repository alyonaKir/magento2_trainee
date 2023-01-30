<?php

namespace Alyona\PostEAV\Model;

use Alyona\PostEAV\Api\Data\CategoryInterface;

class Category extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface, CategoryInterface
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
        return $this->getData(CategoryInterface::ID);
    }

    public function getName()
    {
        return $this->getData(CategoryInterface::NAME);
    }

    public function getUrlKey()
    {
        return $this->getData(CategoryInterface::URL_KEY);
    }

    public function getStatus()
    {
        return $this->getData(CategoryInterface::STATUS);
    }

    public function getCreatedAt()
    {
        return $this->getData(CategoryInterface::CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return $this->getData(CategoryInterface::UPDATED_AT);
    }

    public function setname(string $name)
    {
        $this->setData(CategoryInterface::NAME, $name);
    }

    public function setUrlKey(string $urlKey)
    {
        $this->setData(CategoryInterface::URL_KEY, $urlKey);
    }

    public function setStatus(bool $status)
    {
        $this->setData(CategoryInterface::STATUS, $status);
    }

    public function setCreatedAt($createdAt)
    {
        $this->setData(CategoryInterface::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->setData(CategoryInterface::UPDATED_AT, $updatedAt);
    }
}
