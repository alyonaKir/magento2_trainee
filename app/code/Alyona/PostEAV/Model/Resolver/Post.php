<?php

namespace Alyona\PostEAV\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Post implements ResolverInterface
{
    private $postRecords;

    public function __construct(
        \Alyona\PostEAV\Model\Resolver\DataProvider\PostRecords $postRecords
    ) {
        $this->postRecords = $postRecords;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $postRecords = $this->postRecords->getRecords();
        return $postRecords;
    }
}
