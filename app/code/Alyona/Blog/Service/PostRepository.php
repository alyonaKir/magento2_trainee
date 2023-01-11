<?php

namespace Alyona\Blog\Service;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;

class PostRepository
{
    private $pageRepository;
    private  $searchCriteriaBuilder;
    public function __construct(PageRepositoryInterface $pageRepository, SearchCriteriaBuilder $searchCriteriaBuilder)
    {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @throws LocalizedException
     */
    public function get()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->pageRepository->getList($searchCriteria);
    }
}
