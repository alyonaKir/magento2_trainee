<?php

namespace Alyona\PostEAV\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;

class Content extends Template
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $customFactory;
    protected $parser;
    protected $postRepository;
    protected $tagRepository;
    protected $commentRepository;
    protected $customdataCollection;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Alyona\PostEAV\Model\PostRepository $postRepository
     * @param \Alyona\PostEAV\Model\TagRepository $tagRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Alyona\PostEAV\Model\Post              $customFactory,
        \Alyona\PostEAV\Model\ResourceModel\Post\Grid\CollectionFactory $customdataCollection,
        \Alyona\PostEAV\Model\PostRepository             $postRepository,
        \Alyona\PostEAV\Model\TagRepository              $tagRepository,
        \Alyona\PostEAV\Model\CommentRepository          $commentRepository,
        \Alyona\PostEAV\Model\Parser                     $parser,
        array                                            $data = []
    ) {
        $this->customFactory = $customFactory;
        $this->tagRepository = $tagRepository;
        $this->parser = $parser;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->customdataCollection= $customdataCollection;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('My Custom Pagination'));
        parent::_prepareLayout();
        $page_size = $this->getPagerCount();
        $page_data = $this->getCustomData();
        if ($this->getCustomData()) {
            $pager = $this->getLayout()->createBlock(
                \Alyona\PostEAV\Model\CustomPager::class,
                'custom.pager.name'
            )
                ->setAvailableLimit($page_size)
                ->setShowPerPage(true)
                ->setCollection($page_data);
            $this->setChild('pager', $pager);
            $this->getCustomData()->load();
        }
        return $this;
    }
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    public function getCustomData()
    {
        // get param values
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        // get custom collection
        $this->filterCollection($pageSize);
        $collection = $this->customFactory->getCollection();
        $collection->addFieldToFilter('status', 1);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
    public function getPagerCount()
    {
        $minimum_show = 5;
        $page_array = [];
        $list_data = $this->customdataCollection->create();
        $list_count = ceil(count($list_data->getData()));
        $show_count = $minimum_show + 1;
        if (count($list_data) >= $show_count) {
            $list_count = $list_count / $minimum_show;
            $page_nu = $total = $minimum_show;
            $page_array[$minimum_show] = $minimum_show;
            for ($x = 0; $x <= $list_count; $x++) {
                $total = $total + $page_nu;
                $page_array[$total] = $total;
            }
        } else {
            $page_array[$minimum_show] = $minimum_show;
            $minimum_show = $minimum_show + $minimum_show;
            $page_array[$minimum_show] = $minimum_show;
        }
        return $page_array;
    }

    private function filterCollection()
    {
        $flag = 0;
        $collection = $this->customdataCollection->create();
        $this->reset();
        if ($this->checkGetParametrs()) {
            $this->reset();
            $this->filterByTag($collection, $_GET['tag']);
            return;
        }
        if ($this->getUrlKey() != "" && !$this->isPost()) {
            $_SESSION['categoryName'] = $this->getUrlKey();
            foreach ($collection as $item) {
                foreach ($this->getCategories($item->getId()) as $category) {
                    if ($this->check_categories($this->getCategories($item->getId()), $this->getUrlKey())) {
                        $flag = 1;
                    }
                }
                if ($flag != 1) {
                    $this->hidePostById($item->getId());
                }
                $flag = 0;
            }
        } elseif ($this->isPost()) {
            $_SESSION['curr_post'] = $this->getUrlKey();
            $id = $this->postRepository->getByTitle($this->getUrlKey());
            foreach ($collection as $item) {
                if ($item->getId() != $id) {
                    $this->hidePostById($item->getId());
                }
            }
        } else {
            $this->reset();
        }
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
        return mb_substr($post->getPostContent(), 0, 100) . "...";
    }

    private function hidePostById($id)
    {
        $posts = $this->postRepository;
        $post = $posts->getById($id);
        if ($post->getStatus()==1) {
            $post->setStatus(3);
            $posts->save($post);
        }
//        foreach ($collection as $item) {
//            $collection->removeItemByKey($id);
//        }
//        return $collection;
    }

    private function reset()
    {
        $posts = $this->postRepository->get();
        $postRepository = $this->postRepository;
        foreach ($posts->getItems() as $post) {
            if ($post->getStatus() == 3) {
                $buff = $postRepository->getById($post->getId());
                $buff->setStatus(1);
                $this->postRepository->save($buff);
            }
        }
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
        if (isset($_GET['p'])) {
            return $_SESSION['categoryName'];
        }
        return array_pop($buff_arr);
    }

    private function check_categories($categories, $url_key): bool
    {
        foreach ($categories as $category) {
            if ($category->getUrlKey() == $url_key) {
                return true;
            }
        }
        return false;
    }

    private function checkGetParametrs()
    {
        if (isset($_GET['tag'])) {
            try {
                $tags = $this->tagRepository->getByName($_GET['tag']);
                return true;
            } catch (NoSuchEntityException $exception) {
                return false;
            }
        }
        return false;
    }

    private function filterByTag($collection, $getTag)
    {
        $k = [];
        foreach ($collection as $item) {
            if (!in_array($getTag, $this->getTags($item->getId()))) {
                $this->hidePostById($item->getId());
            } else {
                $k[] = $item->getId();
            }
        }
        $collection->addFieldToFilter('post_id', ['in'=>$k]);
        return $collection;
    }

    public function getAllCommentsByPost(int $postId): array
    {
        $collection = [];
        $comments = $this->commentRepository->get();
        foreach ($comments->getItems() as $comment) {
            if ($comment['post'] == $postId) {
                $collection[] = $comment;
            }
        }
        return $collection;
    }
}
