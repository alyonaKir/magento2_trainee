<?php

namespace Alyona\PostEAV\Model;

use Alyona\PostEAV\Api\Data\PostInterface;
use Alyona\PostEAV\Api\PostRepositoryInterface;
use Alyona\PostEAV\Model\PostSearchResultFactory;
use Alyona\PostEAV\Api\PostSearchResultInterface;
use Alyona\PostEAV\Model\ResourceModel\Post\Grid\CollectionFactory;
use Alyona\PostEAV\Model\ResourceModel\Post\Post as PostResource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class PostRepository implements PostRepositoryInterface
{
    private CollectionFactory $collectionFactory;
    private PostResource $postResource;
    private PostFactory $postFactory;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private PostSearchResultFactory $searchResultFactory;

    /**
     * @param PostFactory $postFactory
     * @param CollectionFactory $collectionFactory
     * @param PostResource $postResource
     * @param PostSearchResultInterfaceFactory $searchResultInterfaceFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        PostFactory $postFactory,
        CollectionFactory $collectionFactory,
        PostResource  $postResource,
        PostSearchResultFactory $searchResultFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->postFactory = $postFactory;
        $this->collectionFactory = $collectionFactory;
        $this->postResource = $postResource;
        $this->searchResultFactory = $searchResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getById(int $id): PostInterface
    {
        $object = $this->postFactory->create();
        $this->postResource->load($object, $id);
        if (! $object->getId()) {
            throw new NoSuchEntityException(__('Unable to find entity with ID "%1"', $id));
        }
        return $object;
    }

    /**
     * @throws LocalizedException
     */
    public function get()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->getList($searchCriteria);
    }
    public function getList(SearchCriteriaInterface $searchCriteria = null): PostSearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        $searchCriteria = $this->searchCriteriaBuilder->create();

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
                foreach ($filterGroup->getFilters() as $filter) {
                    $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                    $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
                }
            }
        }

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult;
    }

    public function save(PostInterface $post): PostInterface
    {
        $this->postResource->save($post);
        return $post;
    }

    public function delete(PostInterface $post): bool
    {
        try {
            $this->postResource->delete($post);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity #%1', $post->getId()));
        }
        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
