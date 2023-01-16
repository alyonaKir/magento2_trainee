<?php

namespace Alyona\Post\Model;

use Alyona\Post\Api\Data\PostInterface;
use Alyona\Post\Api\PostRepositoryInterface;
use Alyona\Post\Api\PostSearchResultInterface;
use Alyona\Post\Model\ResourceModel\Post as PostResource;
use Alyona\Post\Model\ResourceModel\Post\CollectionFactory;
use Alyona\Post\Api\PostSearchResultInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Setup\Exception;

class PostRepository implements PostRepositoryInterface
{
    private CollectionFactory $collectionFactory;
    private PostResource $postResource;
    private PostFactory $postFactory;
    private PostSearchResultInterfaceFactory $searchResultInterfaceFactory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param PostResource $postResource
     * @param \Alyona\Post\Model\PostFactory $postFactory
     * @param PostSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(CollectionFactory $collectionFactory, PostResource $postResource, \Alyona\Post\Model\PostFactory $postFactory, PostSearchResultFactory $searchResultFactory)
    {
        $this->collectionFactory = $collectionFactory;
        $this->postResource = $postResource;
        $this->postFactory = $postFactory;
        $this->searchResultFactory = $searchResultFactory;
    }

    public function get(int $id): PostInterface
    {
        $object = $this->postFactory->create();
        $this->postResource->load($object, $id);
        if(!$object->getId()){
            throw new NoSuchEntityException(__("No id "%1, $id));
        }
        return $object;
    }

    public function getList(SearchCriteriaInterface $searchCriteria):PostSearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filter){
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
        }

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems);
        $searchResult->setTotalCount($collection->getSize);
        return $searchResult;
    }

    public function save(PostInterface $post): PostInterface
    {
        $this->postResource->save($post);
        return $post;
    }

    public function delete(PostInterface $workingHours): bool
    {
        try {
            $this->postResource->delete($workingHours);
        } catch (Exception $e){
            throw new StateException(__("Unable to remove entity "%1, $workingHours->getId()));
        }
        return true;
    }
}
