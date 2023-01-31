<?php

namespace Alyona\PostEAV\Model;

use Alyona\PostEAV\Api\Data\PostInterface;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface, PostInterface
{
    const CACHE_TAG = 'alyona_posteav';

    protected $_cacheTag = 'alyona_posteav';

    protected $_eventPrefix = 'alyona_posteav';

    protected function _construct()
    {
        $this->_init('Alyona\PostEAV\Model\ResourceModel\Post\Post');
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
        return $this->getData(PostInterface::ID);
    }

    public function getTitle()
    {
        return $this->getData(PostInterface::TITLE);
    }

    public function getUrlKey()
    {
        return $this->getData(PostInterface::URL_KEY);
    }

    public function getPostContent()
    {
        return $this->getData(PostInterface::POST_CONTENT);
    }

    public function getTags()
    {
        return $this->getData(PostInterface::TAGS);
    }

    public function getCategoryId()
    {
        return $this->getData(PostInterface::CATEGORY_ID);
    }

    public function getStatus()
    {
        return $this->getData(PostInterface::STATUS);
    }

    public function getCreatedAt()
    {
        return $this->getData(PostInterface::CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return $this->getData(PostInterface::UPDATED_AT);
    }

    public function setTitle(string $title)
    {
        $this->setData(PostInterface::TITLE, $title);
    }

    public function setUrlKey(string $urlKey)
    {
        $this->setData(PostInterface::URL_KEY, $urlKey);
    }

    public function setContent(string $content)
    {
        $this->setData(PostInterface::POST_CONTENT, $content);
    }

    public function setTags(string $tags)
    {
        $this->setData(PostInterface::TAGS, $tags);
    }

    public function setCategoryId(string $category)
    {
        $this->setData(PostInterface::CATEGORY_ID, $category);
    }

    public function setStatus(bool $status)
    {
        $this->setData(PostInterface::STATUS, $status);
    }

    public function setCreatedAt($createdAt)
    {
        $this->setData(PostInterface::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->setData(PostInterface::UPDATED_AT, $updatedAt);
    }

}
