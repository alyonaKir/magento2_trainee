<?php

namespace Alyona\PostEAV\Block;

use Magento\Framework\View\Element\Template;

class Post extends Template
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $postRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Alyona\PostEAV\Model\PostRepository         $postRepository
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Alyona\PostEAV\Model\PostRepository $postRepository,
        array $data = []
    ) {
        $this->postRepository = $postRepository;
        parent::__construct($context, $data);
    }
    public function getPostInfo()
    {
        $id = (int)$_SESSION['post_id'];
        return $this->postRepository->getById($id);
    }
}
