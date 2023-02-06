<?php

namespace Alyona\PostEAV\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Setup\Exception;

class Parser implements ArgumentInterface
{
    private $tagRepository;
    private $categoryRepository;

    public function __construct(
        TagRepository                                                   $tagRepository,
        CategoryRepository                                              $categoryRepository
    ) {
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
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
        $result = [];
        if ($categories != null) {
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

            for ($i = 0; $i < count($categories_arr); $i++) {
                try {
                    $category = $this->categoryRepository->getById((int)$categories_arr[$i]);
                    $result[] = $category->getName();
                } catch (NoSuchEntityException $exception) {
                }
            }
        }
        return $result;
    }
}
