<?php

namespace Alyona\PostEAV\Model;


use Alyona\PostEAV\Api\Data\CommentInterface;

class Comment extends \Magento\Framework\Model\AbstractModel implements CommentInterface
{
    protected function _construct()
    {
        $this->_init('Alyona\PostEAV\Model\ResourceModel\Comment\Comment');
    }

    public function getId()
    {
        $this->getData(CommentInterface::ID);
    }

    public function setId($id)
    {
        $this->setData(CommentInterface::ID, $id);
    }

    public function getName()
    {
        $this->getData(CommentInterface::NAME);
    }

    public function setName(string $name)
    {
        $this->setData(CommentInterface::NAME, $name);
    }

    public function getText()
    {
        $this->getData(CommentInterface::TEXT);
    }

    public function setText(string $text)
    {
        $this->setData(CommentInterface::TEXT, $text);
    }
}
