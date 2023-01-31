<?php

namespace Alyona\PostEAV\Block;

use Magento\Framework\View\Element\Template;

class Navigation extends Template
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $categoryRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Alyona\PostEAV\Model\CategoryRepository $categoryRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Alyona\PostEAV\Model\CategoryRepository             $categoryRepository,
        array                                            $data = []
    )
    {
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context, $data);
    }

    public function getCategories()
    {
        $categories = $this->categoryRepository->get();
        return $categories;
    }
}
