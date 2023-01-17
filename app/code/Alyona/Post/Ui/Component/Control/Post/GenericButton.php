<?php

namespace Alyona\Post\Ui\Component\Control\Post;

use Alyona\Post\Model\PostRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

class GenericButton
{
    private UrlInterface $urlBuilder;
    private RequestInterface $request;
    private PostRepository $postRepository;

    /**
     * @param UrlInterface $urlBuilder
     * @param RequestInterface $request
     * @param PostRepository $postRepository
     */
    public function __construct(UrlInterface $urlBuilder, RequestInterface $request, PostRepository $postRepository)
    {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
        $this->postRepository = $postRepository;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    public function getPost(){
        $postId = $this->request->getParam('id');
        if($postId == null){
            return 0;
        }
        $post = $this->postRepository->get($postId);
        return $post->getId() ?: null;
    }

}
