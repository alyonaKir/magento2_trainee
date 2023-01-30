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

class Category implements ArgumentInterface
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

    public function getCategoryList(): string
    {
        $categories = $this->categoryRepository->get();
        $result = [];

        foreach ($categories->getItems() as $category) {
            $result[] = [
                "id" => $category->getId(),
                "name" => $category->getName(),
                "url" => "https://".$_SERVER['HTTP_HOST']."/blog",
                "updatedAt" => $category->getUpdatedAt()
            ];
        }
        return $this->serializer->serialize($result);
    }
}

