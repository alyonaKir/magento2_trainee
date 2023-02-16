<?php

namespace Alyona\PostEAV\Plugin\Model;

use Magento\Framework\DataObject;

class Sitemap
{
    protected $postRepository;
    protected $categoryRepository;
    public function __construct(
        \Magento\Sitemap\Helper\Data $helper,
        \Alyona\PostEAV\Model\PostRepository $postRepository,
        \Alyona\PostEAV\Model\CategoryRepository $categoryRepository
    ) {
        $this->helper = $helper;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }
    public function beforeGenerateXml(
        \Magento\Sitemap\Model\Sitemap $subject
    ) {
        $storeId = $subject->getStoreId();
//        $newRecords = [];
//        $object = new \Magento\Framework\DataObject();
//        $posts = $this->postRepository->get();
//        foreach ($posts->getItems() as $post) {
//            $object->setId($post->getId());
//            $object->setUrl($post->getUrlKey());
//            $object->setUpdatedAt($post->getUpdatedAt());
//            $newRecords[] = $object;
//        }

        $subject->addSitemapItem(new  \Magento\Framework\DataObject(
            [
                'changefreq' => $this->helper->getPageChangefreq($storeId),
                'priority' => $this->helper->getPagePriority($storeId),
                'collection' => $this->getCustomurlCollection(),
            ]
        ));
    }

    public function getCustomurlCollection()
    {
        $siteMapcollection = [];
        $posts = $this->postRepository->get();
        foreach ($posts->getItems() as $post) {
            $siteMapcollection[] = new DataObject([
                'id' => $post->getId(),
                'url' => "blog/post/" . $post->getUrlKey(),
                'updated_at' => date("Y-m-d h:i:s"),
            ]);
        }

        $categories = $this->categoryRepository->get();
        foreach ($categories->getItems() as $category) {
            $siteMapcollection[] = new DataObject([
                'id' => $post->getId(),
                'url' => "blog/" . $category->getUrlKey(),
                'updated_at' => date("Y-m-d h:i:s"),
            ]);
        }
        return $siteMapcollection;
    }
}
