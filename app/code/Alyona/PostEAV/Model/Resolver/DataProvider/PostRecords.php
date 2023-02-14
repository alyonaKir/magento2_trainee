<?php

namespace Alyona\PostEAV\Model\Resolver\DataProvider;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;

class PostRecords
{
    private $postFactory;

    public function __construct(
        \Alyona\PostEAV\Model\PostFactory $postFactory
    ) {
        $this->postFactory = $postFactory;
    }

    public function getRecords()
    {
        try {
            $collection = $this->postFactory->create()->getCollection();
            $Records = $collection->getData();

        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $Records;
    }
}
