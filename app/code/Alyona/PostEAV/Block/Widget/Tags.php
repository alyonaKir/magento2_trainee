<?php

namespace Alyona\PostEAV\Block\Widget;

use Alyona\PostEAV\Model\Config\Source\Tags as Options;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Tags extends Template implements BlockInterface
{
    protected $options;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Options                                          $options,
        array                                            $data = []
    ) {
        $this->options = $options;
        parent::__construct($context, $data);
    }

    public function returnOptions()
    {
        return $this->options->toOptionArray();
    }
}
