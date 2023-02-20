<?php

namespace Alyona\PostEAV\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

class Enabledisable implements ArrayInterface
{
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Enable',
                'value' => 1
            ],
            1 => [
                'label' => 'Disable',
                'value' => 0
            ],
            2 => [
                'label' => 'Scheduled',
                'value' => 2
            ],
            3 => [
                'label' => 'Enable',
                'value' => 2
            ]
        ];
        return $options;
    }
}
