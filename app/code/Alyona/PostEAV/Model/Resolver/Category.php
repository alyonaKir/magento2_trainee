<?php

namespace Alyona\PostEAV\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Category implements ResolverInterface
{
    private $categoryRecords;

    public function __construct(
        \Alyona\PostEAV\Model\Resolver\DataProvider\CategoryRecords $categoryRecords
    ) {
        $this->categoryRecords = $categoryRecords;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $categoryRecords = $this->categoryRecords->getRecords();
        return $categoryRecords;
    }
}
