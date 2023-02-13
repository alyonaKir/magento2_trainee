<?php

namespace Alyona\PostEAV\Api;

use Alyona\PostEAV\Api\Data\CategoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CategoryRepositoryInterface
{
    /**
     * @param int $id
     * @return \Alyona\PostEAV\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CategoryInterface;
    /**
     * @return \Alyona\PostEAV\Api\CategorySearchResultInterface
     */
    public function get();

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Alyona\PostEAV\Api\CategorySearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): CategorySearchResultInterface;

    /**
     * @param \Alyona\PostEAV\Api\Data\CategoryInterface $category
     * @return \Alyona\PostEAV\Api\Data\CategoryInterface
     */
    public function save(CategoryInterface $category): CategoryInterface;

    /**
     * @param \Alyona\PostEAV\Api\Data\CategoryInterface $category
     * @return bool
     */
    public function delete(CategoryInterface $category): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
