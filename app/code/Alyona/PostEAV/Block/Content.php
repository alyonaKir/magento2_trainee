<?php

namespace Alyona\PostEAV\Block;

use Magento\Framework\View\Element\Template;

class Content extends Template
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
        if (!$this->isPost()) {
            return $this->getChildHtml('pager');
        } else {
            return null;
        }
    }

    public function getProductCollection()
    {
        $flag = 0;
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->postFactory->create()->getCollection();
        $collection = $this->checkEnable($collection);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        if ($this->getUrlKey()!="" && !$this->isPost()) {
            foreach ($collection as $item) {
                foreach ($this->getCategories($item->getId()) as $category) {
                    if ($category == $this->getUrlKey() && count($this->getCategories($item->getId()))>=1) {
                        $flag = 1;
                        break;
                    }
                }
                if ($flag!=1) {
                    $collection = $this->hidePostById($collection, $item->getId());
                }
                $flag = 0;
            }
        } elseif ($this->isPost()) {
            $id = $this->postRepository->getByTitle($this->getUrlKey());
            foreach ($collection as $item) {
                if ($item->getId()!= $id) {
                    $collection = $this->hidePostById($collection, $item->getId());
                }
            }
            // return $this->postRepository->getByTitle($this->getUrlKey());
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
        return $this->parser->getTags($post->getTags());
    }

    public function getPreview($id): string
    {
        $post = $this->postRepository->getById($id);
        return mb_strimwidth($post->getPostContent(), 0, 255) . "...";
    }

    private function hidePostById(&$collection, $id)
    {
        foreach ($collection as $item) {
            $collection->removeItemByKey($id);
        }
        return $collection;
    }

    private function checkEnable(&$collection)
    {
        foreach ($collection as $item) {
            if (!$item->getStatus()) {
                $collection = $this->hidePostById($collection, $item->getId());
            }
        }
        return $collection;
    }

    private function isPost()
    {
        $buff = $_SERVER['REQUEST_URI'];
        $buff_arr = explode('/', $buff);
        if (array_search('post', $buff_arr)) {
            return true;
        }
        return false;
    }
    private function getUrlKey()
    {
        $buff = $_SERVER['REQUEST_URI'];
        $buff_arr = explode('/', $buff);
        if (count($buff_arr) == 2) {
            return "";
        }
        return array_pop($buff_arr);
    }
}
