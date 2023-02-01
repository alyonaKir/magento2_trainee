<?php

namespace Alyona\PostEAV\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\Data\OptionSourceInterface;

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
//        foreach ($this->getOptions() as $value => $label) {
//            $this->attributeOptionsList = [
//                [
//                    'value' => $value,
//                    'label' => $label['name'],
//                    "__disableTmpl" => 1
//                ],
//            ];
//        }
//        return $this->attributeOptionsList;
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
