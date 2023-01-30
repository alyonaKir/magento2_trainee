<?php

namespace Alyona\PostEAV\ViewModel;

use Alyona\PostEAV\Model\PostRepository;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Post implements ArgumentInterface
{
    protected $_collectionFactory;
    protected $_collectionTagFactory;
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

    public function __construct(
        SerializerInterface                                             $serializer,
        PostRepository                                                  $postRepository,
        UrlInterface                                                    $url,
        \Alyona\PostEAV\Model\ResourceModel\Post\Grid\CollectionFactory $collectionFactory,
        \Alyona\PostEAV\Model\ResourceModel\Tag\Grid\CollectionFactory  $collectionTagFactory
    ) {
        $this->serializer = $serializer;
        $this->postRepository = $postRepository;
        $this->url = $url;
        $this->_collectionFactory = $collectionFactory;
        $this->_collectionTagFactory = $collectionTagFactory;
    }

    public function getPosts(): string
    {

        $posts = $this->postRepository->get();
        $result = [];

        foreach ($posts->getItems() as $post) {
            $result[] =[
                "id" => $post->getId(),
                "title" => $post->getTitle(),
                "url" => $post->getUrlKey(),
                "tags" => $this->getTags($post->getTags()),
                "content" => mb_strimwidth($post->getPostContent(), 0, 255) . "...",
                "updatedAt" => $post->getUpdatedAt()
            ];
        }
        return $this->serializer->serialize($result);
    }

    public function getPostInfo($id): string
    {
        $post = $this->postRepository->getById($id);

        $result =[
            "id" => $post->getId(),
            "title" => $post->getTitle(),
            "tags" => $post->getTags(),
            "content" => $post->getPostContent(),
            "updatedAt" => $post->getUpdatedAt()
        ];
        return $this->serializer->serialize($result);
    }

    public function getTags($tags): array
    {
        //return $this->serializer->serialize($result);

        $tags_arr = explode(',', $tags);
        $result =[];
        $i=0;
        $data = $this->_collectionTagFactory->create();
        foreach ($data as $value => $label) {
            if ($tags_arr[$i]==$value) {
                $result[] = $label['name'];
                $i++;
            }
            if ($i>=count($tags_arr)) {
                break;
            }
        }
        return $result;
    }
}
