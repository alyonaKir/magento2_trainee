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

//      $asd = $posts->getItems();
//      $result[] = [
//                "id" => $posts[0]->getId(),
//                "title" =>$post->getTitle(),
//                "url"=>$this->url->getUrl($post->getIdentifier()),
//                "content"=>$post->getContent(),
//                "updatedAt"=>$post->getUpdateTime()
//            ];
//        /**
//         * @var PageInterface $post
//         */
        foreach ($posts->getItems() as $post){
            $result[] =[
                "id" => $post->getId(),
                "title" =>$post->getTitle(),
                "url"=>$this->url->getUrl($post->getIdentifier()),
                "content"=>$post->getContent(),
                "updatedAt"=>$post->getUpdateTime()
            ];
        }

//        $result[] =  [
//                "id" => 1,
//                "title" =>"First Post",
//                "url"=>"https://app.exampleproject.test/blog/first",
//                "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nibh venenatis cras sed felis eget velit aliquet sagittis.",
//                "tags"=> ["cat", "dog"],
//                "updatedAt"=>"2010-10-02"
//            ];
        return $this->serializer->serialize($result);

    }
}
