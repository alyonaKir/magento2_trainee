<?php

namespace Alyona\PostEAV\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Setup\Exception;

class Index extends Action
{
    protected $postRepository;
    public function __construct(
        Context $context,
        \Alyona\PostEAV\Model\PostRepository $postRepository
    ) {
        $this->postRepository = $postRepository;
        parent::__construct($context);
    }

    public function execute()
    {
//        $FormId = $this->getRequest()->getParam('id');
        $_SESSION['post_id'] = $this->getIdByUrlKey();
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $page;
    }

    public function getIdByUrlKey(): int
    {
        $buff = $_SERVER['REQUEST_URI'];
        $buff_arr = explode('/', $buff);
        $url_key = array_pop($buff_arr);
        try {
            $post = $this->postRepository->getByTitle($url_key);
        } catch (\Exception $e) {
            echo "exception";
        }
        return $post;
    }
}
