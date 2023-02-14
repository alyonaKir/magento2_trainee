<?php

namespace Alyona\PostEAV\Api;

use Alyona\PostEAV\Api\Data\CommentInterface;
use Alyona\PostEAV\Model\Comment;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CommentRepositoryInterface
{
    /**
     * @param int $id
     * @return \Alyona\PostEAV\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CommentInterface;

    /**
     * @return \Alyona\PostEAV\Api\CommentSearchResultInterface
     */
    public function get();

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Alyona\PostEAV\Api\CommentSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): CommentSearchResultInterface;

    /**
     * @param \Alyona\PostEAV\Api\Data\CommentInterface $comment
     * @return \Alyona\PostEAV\Api\Data\CommentInterface
     */
    public function save(CommentInterface $comment): CommentInterface;

    /**
     * @param \Alyona\PostEAV\Api\Data\TagInterface $comment
     * @return bool
     */
    public function delete(CommentInterface $comment): bool;

}
