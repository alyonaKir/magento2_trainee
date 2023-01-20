<?php

namespace Alyona\PostEAV\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

class Enabledisable implements ArrayInterface
{
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Active',
                'value' => 1
            ],
            1 => [
                'label' => 'Deactive',
                'value' => 0
            ]
        ];
        return $options;
    }
}
