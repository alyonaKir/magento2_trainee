<?php

namespace Alyona\Blog\ViewModel;

use _PHPStan_503e82092\Nette\Neon\Exception;
use Alyona\Blog\Service\PostRepository;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Blog implements ArgumentInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var PostRepository
     */
    private $postRepository;
    /**
     * @var UrlInterface
     */
    private $url;
    public function __construct(SerializerInterface $serializer,
                                PostRepository $postRepository,
                                UrlInterface $url)
    {
        $this->serializer = $serializer;
        $this->postRepository = $postRepository;
        $this->url = $url;
    }

    public function getPosts():string{
        $posts = $this->postRepository->get();
        $result = [];

        foreach ($posts->getItems() as $post){
            $result[] =[
                "id" => $post->getId(),
                "title" =>$post->getTitle(),
                "url"=>$this->url->getUrl($post->getIdentifier()),
                "content"=>strip_tags($post->getContent()),
                "updatedAt"=>$post->getUpdateTime()
            ];
        }
        return $this->serializer->serialize($result);

    }
}
