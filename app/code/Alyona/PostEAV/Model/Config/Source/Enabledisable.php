<?php

namespace Alyona\PostEAV\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

class Enabledisable implements ArrayInterface
{
    public function toOptionArray()
    {
        $options = [
            1 => [
                'label' => 'Enable',
                'value' => 1
            ],
            0 => [
                'label' => 'Disable',
                'value' => 0
            ],
            2 => [
                'label' => 'Scheduled',
                'value' => 2
            ],
            3 => [
                'label' => 'Enable',
                'value' => 3
            ]
        ];
        return $options;
    }
}
