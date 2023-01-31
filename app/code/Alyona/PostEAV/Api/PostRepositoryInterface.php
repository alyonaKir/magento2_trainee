<?php

namespace Alyona\PostEAV\Api;


use Alyona\PostEAV\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;


interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): PostInterface;
    public function getByTitle(string $url_key): int;
    public function get();

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): PostSearchResultInterface;

    /**
     * @param PostInterface $productTypes
     * @return PostInterface
     */
    public function save(PostInterface $post): PostInterface;

    /**
     * @param PostInterface $post
     * @return bool
     */
    public function delete(PostInterface $post): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
