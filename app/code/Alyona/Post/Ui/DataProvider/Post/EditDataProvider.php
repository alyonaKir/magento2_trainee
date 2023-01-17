<?php

namespace Alyona\Post\Ui\DataProvider\Post;


use Alyona\Post\Model\ResourceModel\Post\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class EditDataProvider extends AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getDataSourceData(){
        return [];
    }
    public function getData()
    {
        return parent::getData();
    }

    public function getMeta()
    {
        return parent::getMeta();
    }
}
