<?php

namespace Alyona\PostEAV\Api;

use Alyona\PostEAV\Api\Data\CategoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CategoryRepositoryInterface
{
    /**
     * @param int $id
     * @return CategoryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CategoryInterface;
    public function get();

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CategorySearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): CategorySearchResultInterface;

    /**
     * @param CategoryInterface $category
     * @return CategoryInterface
     */
    public function save(CategoryInterface $category): CategoryInterface;

    /**
     * @param CategoryInterface $category
     * @return bool
     */
    public function delete(CategoryInterface $category): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
