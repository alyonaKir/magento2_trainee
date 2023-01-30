<?php

namespace Alyona\PostEAV\Model;

use Alyona\PostEAV\Api\CategoryRepositoryInterface;
use Alyona\PostEAV\Api\CategorySearchResultInterface;
use Alyona\PostEAV\Api\Data\CategoryInterface;
use Alyona\PostEAV\Model\ResourceModel\Category\Grid\CollectionFactory;
use Alyona\PostEAV\Model\ResourceModel\Category\Category as CategoryResource;
use Alyona\PostEAV\Model\CategoryFactory;
use Alyona\PostEAV\Model\CategorySearchResultFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class CategoryRepository implements CategoryRepositoryInterface
{
    private CollectionFactory $collectionFactory;
    private CategoryResource $categoryResource;
    private CategoryFactory $categoryFactory;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private CategorySearchResultFactory $searchResultFactory;

    /**
     * @param CategoryFactory $categoryFactory
     * @param CollectionFactory $collectionFactory
     * @param CategoryResource $categoryResource
     * @param CategorySearchResultInterfaceFactory $searchResultInterfaceFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        CollectionFactory $collectionFactory,
        CategoryResource  $categoryResource,
        CategorySearchResultFactory $searchResultFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->collectionFactory = $collectionFactory;
        $this->categoryResource = $categoryResource;
        $this->searchResultFactory = $searchResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }
    public function getById(int $id): CategoryInterface
    {
        $object = $this->categoryFactory->create();
        $this->categoryResource->load($object, $id);
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

    public function getList(SearchCriteriaInterface $searchCriteria = null): CategorySearchResultInterface
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

    public function save(CategoryInterface $category): CategoryInterface
    {
        $this->categoryResource->save($category);
        return $category;
    }

    public function delete(CategoryInterface $category): bool
    {
        try {
            $this->categoryResource->delete($category);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity #%1', $category->getId()));
        }
        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
