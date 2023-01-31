<?php

namespace Alyona\PostEAV\ViewModel;

use Alyona\PostEAV\Model\CategoryRepository;
use Alyona\PostEAV\Model\PostRepository;
use Alyona\PostEAV\Model\TagRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Setup\Exception;

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
    private $tagRepository;
    private $categoryRepository;

    public function __construct(
        SerializerInterface                                             $serializer,
        PostRepository                                                  $postRepository,
        TagRepository                                                   $tagRepository,
        CategoryRepository                                              $categoryRepository,
        UrlInterface                                                    $url,
        \Alyona\PostEAV\Model\ResourceModel\Post\Grid\CollectionFactory $collectionFactory,
        \Alyona\PostEAV\Model\ResourceModel\Tag\Grid\CollectionFactory  $collectionTagFactory
    ) {
        $this->serializer = $serializer;
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
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
                "category" => $this->getCategories($post->getCategoryId()),
                "content" => mb_strimwidth($post->getPostContent(), 0, 255) . "...",
                "updatedAt" => $post->getUpdatedAt()
            ];
        }
        return $this->serializer->serialize($result);
    }

    public function getPostInfo(): string
    {
        $id = (int)$_SESSION['post_id'];
        $post = $this->postRepository->getById($id);

        $result =[
            "id" => $post->getId(),
            "title" => $post->getTitle(),
            "tags" => $this->getTags($post->getTags()),
            "category" => $this->getCategories($post->getCategoryId()),
            "content" => $post->getPostContent(),
            "updatedAt" => $post->getUpdatedAt()
        ];
        return $this->serializer->serialize($result);
    }

    public function getTags(string $tags): array
    {
        $tags_arr = explode(',', $tags);
        $result =[];

        for ($i=0; $i<count($tags_arr);$i++) {
            try {
                $tag = $this->tagRepository->getById((int)$tags_arr[$i]);
                $result[] = $tag->getName();
            } catch (NoSuchEntityException $exception) {
            }
        }
        return $result;
    }

    public function getCategories(string $categories): array
    {
        $result =[];
        try {
            $categories_arr = explode(',', $categories);
        } catch (Exception $exception) {
            try {
                $result[] = $this->categoryRepository->getById((int)$categories);
                return $result;
            } catch (Exception $exception) {
                return $result;
            }
        }

        for ($i=0; $i<count($categories_arr);$i++) {
            try {
                $category = $this->categoryRepository->getById((int)$categories_arr[$i]);
                $result[] = $category->getName();
            } catch (NoSuchEntityException $exception) {
            }
        }
        return $result;
    }
}
