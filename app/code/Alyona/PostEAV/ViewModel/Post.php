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
        $data = $this->_collectionFactory->create();

        foreach ($data as $value => $label) {
            $result[] = [
                "id" => $label['post_id'],
                "title" => $label['title'],
                "url" => $label['url_key'],
                "tags" => $this->getTags($label['tags']),
                "content" => mb_strimwidth($label['post_content'], 0, 255)."...",
                "updatedAt" => $label['updated_at']
            ];
        }
        return $this->serializer->serialize($result);
    }

    public function getTags($tags): array
    {
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
