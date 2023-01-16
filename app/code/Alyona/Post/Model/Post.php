<?php

namespace Alyona\Post\Model;

use Alyona\Post\Api\Data\PostInterface;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements PostInterface
{

    public function getId(): int
    {
        return $this->getData(PostInterface::ID);
    }

    public function getTitle(): string
    {
        return $this->getData(PostInterface::TITLE);
    }

    public function getContent(): string
    {
        return $this->getData(PostInterface::CONTENT);
    }

    public function getCreatedAt(): string
    {
        return $this->getData(PostInterface::CREATED_AT);
    }

    public function getUpdatedAt(): string
    {
        return $this->getData(PostInterface::UPDATED_AT);
    }

    public function setTitle($title)
    {
        $this->setData(PostInterface::TITLE, $title);
    }

    public function setContent($content)
    {
        $this->setData(PostInterface::CONTENT, $content);
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
