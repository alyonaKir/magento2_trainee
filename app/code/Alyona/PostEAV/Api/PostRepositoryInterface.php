<?php

namespace Alyona\PostEAV\Api;


use Alyona\PostEAV\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;


interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return \Alyona\PostEAV\Api\Data\PostInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): PostInterface;

    /**
     * @param string $url_key
     * @return int
     * @throws NoSuchEntityException
     */
    public function getByTitle(string $url_key): int;

    /**
     * @return \Alyona\PostEAV\Api\PostSearchResultInterface
     */
    public function get(): PostSearchResultInterface;

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return \Alyona\PostEAV\Api\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): PostSearchResultInterface;

    /**
     * @param \Alyona\PostEAV\Api\Data\PostInterface $post
     * @return \Alyona\PostEAV\Api\Data\PostInterface
     */
    public function save(PostInterface $post): PostInterface;

    /**
     * @param \Alyona\PostEAV\Api\Data\PostInterface $post
     * @return bool
     */
    public function delete(PostInterface $post): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
