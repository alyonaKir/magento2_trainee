<?php

namespace Alyona\PostEAV\Api;

use Alyona\PostEAV\Api\Data\TagInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface TagRepositoryInterface
{
    /**
     * @param int $id
     * @return TagInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): TagInterface;
    public function get();

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TagSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): TagSearchResultInterface;

    /**
     * @param TagInterface $tag
     * @return TagInterface
     */
    public function save(TagInterface $tag): TagInterface;

    /**
     * @param TagInterface $tag
     * @return bool
     */
    public function delete(TagInterface $tag): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
