<?php

namespace Alyona\PostEAV\Model;

use Alyona\PostEAV\Api\CommentRepositoryInterface;
use Alyona\PostEAV\Api\CommentSearchResultInterface;
use Alyona\PostEAV\Api\Data\CommentInterface;
use Alyona\PostEAV\Model\ResourceModel\Comment\CollectionFactory;
use Alyona\PostEAV\Model\ResourceModel\Comment\Comment as CommentResource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class CommentRepository implements CommentRepositoryInterface
{
    private CollectionFactory $collectionFactory;
    private CommentResource $commentResource;
    private CommentFactory $commentFactory;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private CommentSearchResultFactory $searchResultFactory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param CommentResource $commentResource
     * @param CommentFactory $commentFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CommentSearchResultFactory $searchResultFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CommentResource $commentResource,
        CommentFactory $commentFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CommentSearchResultFactory $searchResultFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->commentResource = $commentResource;
        $this->commentFactory = $commentFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultFactory = $searchResultFactory;
    }

    public function getById(int $id): CommentInterface
    {
        $object = $this->commentFactory->create();
        $this->commentResource->load($object, $id);
        if (! $object->getId()) {
            throw new NoSuchEntityException(__('Unable to find entity with ID "%1"', $id));
        }
        return $object;
    }

    public function get()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->getList($searchCriteria);
    }

    public function getList(SearchCriteriaInterface $searchCriteria = null): CommentSearchResultInterface
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

    public function save(CommentInterface $comment): CommentInterface
    {
        $this->commentResource->save($comment);
        return $comment;
    }

    public function delete(CommentInterface $comment): bool
    {
        try {
            $this->commentResource->delete($comment);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity #%1', $comment->getId()));
        }
        return true;
    }
}
