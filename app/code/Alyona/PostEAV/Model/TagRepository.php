<?php

namespace Alyona\PostEAV\Model;

use Alyona\PostEAV\Api\Data\TagInterface;
use Alyona\PostEAV\Api\TagRepositoryInterface;
use Alyona\PostEAV\Api\TagSearchResultInterface;
use Alyona\PostEAV\Model\ResourceModel\Tag\Grid\CollectionFactory;
use Alyona\PostEAV\Model\ResourceModel\Tag\Tag as TagResource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Alyona\PostEAV\Model\TagFactory;
use Alyona\PostEAV\Model\TagSearchResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class TagRepository implements TagRepositoryInterface
{

    private CollectionFactory $collectionFactory;
    private TagResource $tagResource;
    private TagFactory $tagFactory;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private TagSearchResultFactory $searchResultFactory;

    /**
     * @param TagFactory $tagFactory
     * @param CollectionFactory $collectionFactory
     * @param TagResource $tagResource
     * @param TagSearchResultInterfaceFactory $searchResultInterfaceFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        TagFactory $tagFactory,
        CollectionFactory $collectionFactory,
        TagResource  $tagResource,
        TagSearchResultFactory $searchResultFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->tagFactory = $tagFactory;
        $this->collectionFactory = $collectionFactory;
        $this->tagResource = $tagResource;
        $this->searchResultFactory = $searchResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getById(int $id): TagInterface
    {
        $object = $this->tagFactory->create();
        $this->tagResource->load($object, $id);
        if (! $object->getId()) {
            throw new NoSuchEntityException(__('Unable to find entity with ID "%1"', $id));
        }
        return $object;
    }

    public function getByName(string $name): int
    {
        $tags = $this->get();
        foreach ($tags->getItems() as $tag) {
            if ($tag->getName()==$name) {
                return $tag->getId();
            }
        }
        throw new NoSuchEntityException(__('Unable to find entity with ID "%1"', $tag));
    }

    public function get()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->getList($searchCriteria);
    }

    public function getList(SearchCriteriaInterface $searchCriteria = null): TagSearchResultInterface
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

    public function save(TagInterface $tag): TagInterface
    {
        $this->tagResource->save($tag);
        return $tag;
    }

    public function delete(TagInterface $tag): bool
    {
        try {
            $this->tagResource->delete($tag);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity #%1', $tag->getId()));
        }
        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
