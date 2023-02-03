<?php

namespace Alyona\PostEAV\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

class Tags implements ArrayInterface
{
    protected $_collectionFactory;

    /**
     * @var array|null
     */
    protected $_options;

    /**
     * @param \Alyona\PostEAV\Model\ResourceModel\Tag\Grid\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Alyona\PostEAV\Model\ResourceModel\Tag\Grid\CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $result = [];
        foreach ($this->getOptions() as $value => $label) {
            $result[] = [
                'value' => $label['tag_id'],
                'label' => $label['name'],
            ];
        }

        return $result;
    }

    public function getOptions()
    {
        $data = $this->_collectionFactory->create();
        return $data->getData();
    }
}
