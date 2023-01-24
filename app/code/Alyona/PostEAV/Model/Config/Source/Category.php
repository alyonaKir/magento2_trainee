<?php

namespace Alyona\PostEAV\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Category implements ArrayInterface
{
    protected $_collectionFactory;

    /**
     * @var array|null
     */
    protected $_options;

    /**
     * @param \Alyona\PostEAV\Model\ResourceModel\Category\Grid\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Alyona\PostEAV\Model\ResourceModel\Category\Grid\CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $result = [];
        foreach ($this->getOptions() as $value => $label) {
            if ($label['status']) {
                $result[] = [
                    'value' => $value,
                    'label' => $label['name'],
                ];
            }
        }

        return $result;
    }

    public function getOptions()
    {
        $data = $this->_collectionFactory->create();
        return $data->getData();
    }
}
