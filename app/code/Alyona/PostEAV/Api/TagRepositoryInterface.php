<?php

namespace Alyona\PostEAV\Api;

use Alyona\PostEAV\Api\Data\TagInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface TagRepositoryInterface
{
    /**
     * @param int $id
     * @return \Alyona\PostEAV\Api\Data\TagInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): TagInterface;

    /**
     * @return \Alyona\PostEAV\Api\TagSearchResultInterface
     */
    public function get();

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Alyona\PostEAV\Api\TagSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): TagSearchResultInterface;

    /**
     * @param \Alyona\PostEAV\Api\Data\TagInterface $tag
     * @return \Alyona\PostEAV\Api\Data\TagInterface
     */
    public function save(TagInterface $tag): TagInterface;

    /**
     * @param \Alyona\PostEAV\Api\Data\TagInterface $tag
     * @return bool
     */
    public function delete(TagInterface $tag): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
