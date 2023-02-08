<?php

namespace Alyona\PostEAV\Model;

use Alyona\PostEAV\Model\ResourceModel\Post\Grid\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];

        foreach ($items as $post) {
            $this->loadedData[$post->getId()]['post_fieldset'] = $post->getData();
        }

        return $this->loadedData;
    }

}
