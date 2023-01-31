<?php

namespace Alyona\PostEAV\Block;

use Magento\Framework\View\Element\Template;

class Pager extends Template
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $postFactory;
    protected $parser;
    protected $postRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Alyona\PostEAV\Model\PostRepository $postRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Alyona\PostEAV\Model\PostFactory                $postFactory,
        \Alyona\PostEAV\Model\PostRepository             $postRepository,
        \Alyona\PostEAV\Model\Parser                     $parser,
        array                                            $data = []
    ) {
        $this->postFactory = $postFactory;
        $this->parser = $parser;
        $this->postRepository = $postRepository;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Blog'));
        if ($this->getProductCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getProductCollection()
                );
            $this->setChild('pager', $pager);
            $this->getProductCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getProductCollection()
    {
        $flag = 0;
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->postFactory->create()->getCollection();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        if ($this->getIdByUrlKey()!="") {
            foreach ($collection as $item) {
                foreach ($this->getCategories($item->getId()) as $category) {
                    if ($category == $this->getIdByUrlKey()) {
                        $flag = 1;
                    }
                }
                if ($flag!=1) {
                    $collection = $this->hidePostById($collection, $item->getId());
                }
                $flag = 0;
            }
        }
        return $collection;
    }

    public function getCategories($id): array
    {
        $post = $this->postRepository->getById($id);
        return $this->parser->getCategories($post->getCategoryId());
    }

    public function getTags($id): array
    {
        $post = $this->postRepository->getById($id);
        return $this->parser->getCategories($post->getTags());
    }

    public function getPostInfo()
    {
        $id = (int)$_SESSION['post_id'];
        return $this->postRepository->getById($id);
    }

    public function getPreview($id): string
    {
        $post = $this->postRepository->getById($id);
        return mb_strimwidth($post->getPostContent(), 0, 255) . "...";
    }

    public function hidePostById(&$collection, $id)
    {
        foreach ($collection as $item) {
            $collection->removeItemByKey($id);
        }
        return $collection;
    }

    public function getIdByUrlKey()
    {
        $buff = $_SERVER['REQUEST_URI'];
        $buff_arr = explode('/', $buff);
        if(count($buff_arr) == 2){
            return "";
        }
        return array_pop($buff_arr);
    }
}
