<?php

namespace Alyona\PostEAV\Model\Config\Source;

use Alyona\PostEAV\Model\Category as CategoryModel;
use Alyona\PostEAV\Model\ResourceModel\Category\Grid\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Options tree for "Categories" field
 */
class CategoryTree implements OptionSourceInterface
{
    /**
     * @var \Alyona\PostEAV\Model\ResourceModel\Category\Grid\CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $categoriesTree;

    /**
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param RequestInterface $request
     */
    public function __construct(
        CategoryCollectionFactory $categoryCollectionFactory,
        RequestInterface $request
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getCategoriesTree();
    }

    /**
     * Retrieve categories tree
     *
     * @return array
     */
    protected function getCategoriesTree()
    {
        if ($this->categoriesTree === null) {
//            $storeId = $this->request->getParam('store');
            /* @var $matchingNamesCollection \Alyona\PostEAV\Model\ResourceModel\Category\Grid\CollectionFactory */
            $matchingNamesCollection = $this->categoryCollectionFactory->create();

//            $matchingNamesCollection->addAttributeToSelect('path')
//                ->addAttributeToFilter('category_id', ['neq' => CategoryModel::ID])
//                ->setStoreId($storeId);

            $shownCategoriesIds = [];

            /** @var \Alyona\PostEAV\Model\Category $category */
            foreach ($matchingNamesCollection as $category) {
                foreach (explode('/', $category->getPath()) as $parentId) {
                    $shownCategoriesIds[$category->getId()] = 1;
                }
            }

            /* @var $collection \Alyona\PostEAV\Model\ResourceModel\Category\Grid\CollectionFactory*/
            $collection = $this->categoryCollectionFactory->create();

//            $collection->addAttributeToFilter('entity_id', ['in' => array_keys($shownCategoriesIds)])
//                ->addAttributeToSelect(['name', 'is_active', 'parent_id'])
//                ->setStoreId($storeId);

            $categoryById = [
                CategoryModel::ID => [
                    'value' => CategoryModel::ID
                ],
            ];
            foreach ($collection as $category) {
                if ($category->getData('level') <= 2) {
                    foreach ([$category->getId(), $category->getParentId()] as $categoryId) {
                        if (!isset($categoryById[$categoryId])) {
                            $categoryById[$categoryId] = ['value' => $categoryId];
                        }
                    }
                    $categoryById[$category->getId()]['is_active'] = $category->getIsActive();
                    $categoryById[$category->getId()]['label'] = $category->getName();
                    $categoryById[$category->getParentId()]['optgroup'][] = &$categoryById[$category->getId()];
                }
            }
            $this->categoriesTree = $categoryById[CategoryModel::ID]['optgroup'];
        }

        return $this->categoriesTree;
    }
}
