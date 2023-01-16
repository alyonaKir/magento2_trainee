<?php

namespace Alyona\Post\Api;

use Alyona\Post\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Setup\Exception;

interface PostRepositoryInterface
{
    public function get(int $id): PostInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): PostSearchResultInterface;

    public function save(PostInterface $post): PostInterface;
    public function delete(PostInterface $workingHours): bool;
}
